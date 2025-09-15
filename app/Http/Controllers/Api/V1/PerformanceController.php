<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePerformanceRequest;
use App\Models\EventDiscipline;
use App\Models\Performance;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PerformanceController extends Controller
{
    /**
     * @group Performances
     * List performances
     * @queryParam athlete_id uuid Filter på utøver.
     * @queryParam event_id uuid Filter på stevne.
     * @queryParam discipline_code string Filter på øvelse (f.eks. 100m).
     * @queryParam date_from date yyyy-mm-dd.
     * @queryParam date_to date yyyy-mm-dd.
     * @queryParam legal boolean true/false.
     * @queryParam status string OK/DQ/DNF/DNS/NM.
     * @queryParam sort string Sorteringsfelt. Example: -created_at
     * @unauthenticated
     */
    public function index()
{
    /**
     * @group Performances
     * Create performance
     * @bodyParam event_id uuid required Stevne-ID.
     * @bodyParam discipline_code string required Øvelseskode. Example: 100m
     * @bodyParam age_category string Klasse. Example: Senior
     * @bodyParam round string Runde. Example: finale
     * @bodyParam timing_method string Tidtaking (hand/auto/chip). Example: auto
     * @bodyParam athlete_id uuid required_without:relay_team_id Utøver-ID.
     * @bodyParam unit string required s|m|km. Example: s
     * @bodyParam mark_display string Prestasjon som tekst (f.eks. "11.72" eller "1:59.12").
     * @bodyParam mark_raw integer Prestasjon normalisert (ms/mm).
     * @bodyParam position integer Plassering. Example: 1
     * @bodyParam wind number Vind (m/s). Example: 1.1
     * @bodyParam status string OK/DQ/DNF/DNS/NM. Example: OK
     * @bodyParam is_legal boolean Lovlig result. Example: true
     * @unauthenticated
     */
    $sort = request('sort', '-created_at'); // e.g. '-created_at', 'mark_raw', '-mark_raw'
    $dir  = str_starts_with($sort, '-') ? 'desc' : 'asc';
    $col  = ltrim($sort, '-');

    return Performance::query()
        ->with(['eventDiscipline.event'])
        // Filtre
        ->when(request('athlete_id'), fn($q, $id) => $q->where('athlete_id', $id))
        ->when(request('event_id'), fn($q, $id) => $q->whereHas('eventDiscipline', fn($qq)=>$qq->where('event_id',$id)))
        ->when(request('discipline_code'), fn($q, $code) => $q->whereHas('eventDiscipline', fn($qq)=>$qq->where('discipline_code',$code)))
        ->when(request('date_from'), fn($q, $d) => $q->whereHas('eventDiscipline.event', fn($qq)=>$qq->whereDate('start_date','>=',$d)))
        ->when(request('date_to'), fn($q, $d) => $q->whereHas('eventDiscipline.event', fn($qq)=>$qq->whereDate('start_date','<=',$d)))
        ->when(request('legal') !== null, fn($q, $v) => $q->where('is_legal', filter_var($v, FILTER_VALIDATE_BOOL)))
        ->when(request('status'), fn($q, $s) => $q->where('status', $s))
        // Sortering
        ->when(in_array($col, ['created_at','mark_raw','position']), fn($q) => $q->orderBy($col, $dir),
            fn($q)=>$q->orderBy('created_at','desc'))
        ->paginate(request('per_page', 50));
}

    public function store(StorePerformanceRequest $request)
    {
        $data = $request->validated();

        // Finn/lag event_discipline for dette eventet + disiplinen
        $ed = EventDiscipline::firstOrCreate(
            [
                'event_id'        => $data['event_id'],
                'discipline_code' => $data['discipline_code'],
            ],
            [
                'age_category'   => $data['age_category'] ?? 'Senior',
                'round'          => $data['round'] ?? 'finale',
                'timing_method'  => $data['timing_method'] ?? 'auto',
                'is_team_scored' => false,
            ]
        );

        // Normaliser mark_raw/mark_display
        [$markRaw, $markDisplay, $unit] = $this->normalizeMark(
            $data['unit'],
            $data['mark_raw'] ?? null,
            $data['mark_display'] ?? null
        );

        $payload = [
            'event_discipline_id' => $ed->id,
            'athlete_id'          => $data['athlete_id'] ?? null,
            'relay_team_id'       => $data['relay_team_id'] ?? null,
            'mark_raw'            => $markRaw,
            'mark_display'        => $markDisplay,
            'unit'                => $unit,
            'position'            => $data['position'] ?? null,
            'wind'                => $data['wind'] ?? null,
            'status'              => $data['status'] ?? 'OK',
            'is_legal'            => $data['is_legal'] ?? true,
            'splits_json'         => $data['splits'] ?? null,
            'device_meta_json'    => null,
            'version_group_id'    => (string) Str::uuid(),
            'is_current'          => true,
            'submitted_by'        => null,
            'submitted_at'        => now(),
            'signature_id'        => null,
            'hash'                => null,
        ];

        $perf = DB::transaction(fn() => Performance::create($payload));

        return response()->json($perf, 201);
    }

    private function normalizeMark(string $unit, ?int $markRaw, ?string $markDisplay): array
    {
        // Hvis mark_raw mangler: forsøk å beregne fra mark_display
        if ($markRaw === null && $markDisplay !== null) {
            $clean = trim($markDisplay);

            if ($unit === 's') {
                // Støtt "m:ss.xx" eller "ss.xx"
                if (str_contains($clean, ':')) {
                    [$m, $s] = explode(':', $clean, 2);
                    $seconds = ((int)$m) * 60 + (float)$s;
                } else {
                    $seconds = (float) $clean;
                }
                $markRaw = (int) round($seconds * 1000); // ms
                $markDisplay = number_format($seconds, 2, '.', '');
            }
            elseif ($unit === 'm') {
                // meter med desimal → mm
                $meters = (float) $clean;
                $markRaw = (int) round($meters * 1000);
                $markDisplay = number_format($meters, 2, '.', '');
            }
            elseif ($unit === 'km') {
                // Anbefaling: tidsenhet i sekunder, men vi beholder 'km' hvis du ønsker.
                // Her tolker vi display som tid og lagrer raw i ms.
                if (str_contains($clean, ':')) {
                    // støtte "h:mm:ss" eller "m:ss"
                    $parts = array_map('floatval', explode(':', $clean));
                    $seconds = 0;
                    foreach ($parts as $p) { $seconds = $seconds * 60 + $p; }
                } else {
                    $seconds = (float) $clean;
                }
                $markRaw = (int) round($seconds * 1000);
                $markDisplay = number_format($seconds, 2, '.', '');
            }
        }

        if ($markRaw === null) {
            abort(422, 'mark_raw eller mark_display må oppgis.');
        }
        return [$markRaw, $markDisplay ?? (string)$markRaw, $unit];
    }
}
