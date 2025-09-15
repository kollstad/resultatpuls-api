<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePerformanceRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'event_id'         => ['required','uuid','exists:events,id'],
            'discipline_code'  => ['required','string','exists:disciplines,code'],
            'age_category'     => ['nullable','string','max:16'],
            'round'            => ['nullable','string','max:16'],
            'timing_method'    => ['nullable','in:hand,auto,chip'],

            'athlete_id'       => ['required_without:relay_team_id','uuid','exists:athletes,id'],
            'relay_team_id'    => ['nullable','uuid'], // stafett senere

            // ytelse
            'unit'             => ['required','in:s,m,km'],
            // minst ett av disse to: mark_display (f.eks "10.87") ELLER mark_raw (ms/mm)
            'mark_display'     => ['nullable','string','max:24'],
            'mark_raw'         => ['nullable','integer','min:0'],
            'position'         => ['nullable','integer','min:1'],
            'wind'             => ['nullable','numeric','between:-9.9,9.9'],
            'status'           => ['nullable','in:OK,DQ,DNF,DNS,NM'],
            'is_legal'         => ['nullable','boolean'],
            'splits'           => ['nullable','array'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'event_id' => [
                'description' => 'UUID for stevnet.',
                'example' => '3e7a9c00-9abc-4dcd-8123-abcdef123456',
            ],
            'discipline_code' => [
                'description' => 'Øvelseskode (f.eks. 100m, LJ, MAR).',
                'example' => '100m',
            ],
            'age_category' => [
                'description' => 'Aldersklasse (valgfri).',
                'example' => 'Senior',
            ],
            'round' => [
                'description' => 'Runde (valgfri).',
                'example' => 'finale',
            ],
            'timing_method' => [
                'description' => 'Tidtaking (hand/auto/chip) (valgfri).',
                'example' => 'auto',
            ],
            'athlete_id' => [
                'description' => 'UUID for utøver (påkrevd hvis ikke stafett).',
                'example' => '4f2c7f11-aaaa-4bbb-cccc-1234567890ab',
            ],
            'relay_team_id' => [
                'description' => 'UUID for stafettlag (ikke brukt i MVP).',
                'example' => null,
            ],
            'unit' => [
                'description' => 'Enhet for prestasjon: s, m eller km.',
                'example' => 's',
            ],
            'mark_display' => [
                'description' => 'Prestasjon som tekst (f.eks. "11.72" eller "1:59.12").',
                'example' => '11.72',
            ],
            'mark_raw' => [
                'description' => 'Prestasjon normalisert (ms for tid, mm for lengde/kast).',
                'example' => 11720,
            ],
            'position' => [
                'description' => 'Plassering (valgfri).',
                'example' => 1,
            ],
            'wind' => [
                'description' => 'Vind (m/s, valgfri).',
                'example' => 1.1,
            ],
            'status' => [
                'description' => 'Status (OK, DQ, DNF, DNS, NM).',
                'example' => 'OK',
            ],
            'is_legal' => [
                'description' => 'Lovlighet (vind/implement/timing).',
                'example' => true,
            ],
            'splits' => [
                'description' => 'Mellomtider som array (valgfri).',
                'example' => [ "5k: 16:20", "10k: 33:20" ],
            ],
        ];
    }
}
