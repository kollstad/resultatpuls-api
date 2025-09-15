<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'           => ['required','string','max:255'],
            'type'           => ['required','in:indoor,outdoor,road,xc,trail'],
            'start_date'     => ['required','date'],
            'end_date'       => ['nullable','date','after_or_equal:start_date'],
            'city'           => ['nullable','string','max:120'],
            'venue'          => ['nullable','string','max:120'],
            'sanction_level' => ['nullable','string','max:32'],
            'course_cert'    => ['nullable','string','max:32'],
            'elevation_gain' => ['nullable','integer','min:0'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Navn på stevnet.',
                'example' => 'Sommerstevnet Kristiansand',
            ],
            'type' => [
                'description' => 'Type: indoor, outdoor, road, xc, trail.',
                'example' => 'outdoor',
            ],
            'start_date' => [
                'description' => 'Startdato (YYYY-MM-DD).',
                'example' => '2025-09-13',
            ],
            'end_date' => [
                'description' => 'Sluttdato (valgfri).',
                'example' => '2025-09-13',
            ],
            'city' => [
                'description' => 'By (valgfri).',
                'example' => 'Kristiansand',
            ],
            'venue' => [
                'description' => 'Stadion/arena (valgfri).',
                'example' => 'Kristiansand stadion',
            ],
            'sanction_level' => [
                'description' => 'Godkjenningsnivå (valgfri).',
                'example' => 'Regional',
            ],
            'course_cert' => [
                'description' => 'Løypesertifikat (vei) (valgfri).',
                'example' => 'AIMS',
            ],
            'elevation_gain' => [
                'description' => 'Stigning (trail) i meter (valgfri).',
                'example' => 350,
            ],
        ];
    }
}
