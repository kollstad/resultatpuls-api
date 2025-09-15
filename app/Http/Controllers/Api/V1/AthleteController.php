<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAthleteRequest;
use App\Models\Athlete;

class AthleteController extends Controller
{
    /**
     * @group Athletes
     * List athletes
     * @queryParam club_id uuid Filter på klubb.
     * @queryParam q string Søk i fornavn/etternavn/sports_id.
     * @unauthenticated
     */
    public function index()
{
    /**
     * @group Athletes
     * Create athlete
     * @bodyParam sports_id string required Idrettens-id. Example: NOR-000123
     * @bodyParam first_name string required Fornavn. Example: Kari
     * @bodyParam last_name string required Etternavn. Example: Nordmann
     * @bodyParam dob date required Fødselsdato (YYYY-MM-DD). Example: 2001-03-10
     * @bodyParam gender string required Kjønn (M/F/X). Example: F
     * @bodyParam club_id uuid required Tilhørende klubb (uuid).
     * @bodyParam nationality string ISO3. Example: NOR
     * @unauthenticated
     */
    return Athlete::query()
        ->with('club')
        ->when(request('club_id'), fn($q, $id) => $q->where('club_id', $id))
        ->when(request('q'), function ($q, $term) {
            $q->where(function ($qq) use ($term) {
                $qq->where('first_name', 'ilike', "%$term%")
                   ->orWhere('last_name', 'ilike', "%$term%")
                   ->orWhere('sports_id', 'ilike', "%$term%");
            });
        })
        ->orderBy('last_name')->orderBy('first_name')
        ->paginate(request('per_page', 50));
}

    public function store(StoreAthleteRequest $request)
    {
        $athlete = Athlete::create($request->validated());
        return response()->json($athlete, 201);
    }
}
