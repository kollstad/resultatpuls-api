<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAthleteRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'sports_id'  => ['required','string','max:50','unique:athletes,sports_id'],
            'first_name' => ['required','string','max:100'],
            'last_name'  => ['required','string','max:100'],
            'dob'        => ['required','date'],
            'gender'     => ['required','in:M,F,X'],
            'club_id'    => ['required','uuid','exists:clubs,id'],
            'nationality'=> ['nullable','string','size:3'],
            'status'     => ['nullable','string','max:20'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'sports_id' => [
                'description' => 'Idrettens-id (unik).',
                'example' => 'NOR-000123',
            ],
            'first_name' => [
                'description' => 'Fornavn.',
                'example' => 'Kari',
            ],
            'last_name' => [
                'description' => 'Etternavn.',
                'example' => 'Nordmann',
            ],
            'dob' => [
                'description' => 'Fødselsdato (YYYY-MM-DD).',
                'example' => '2001-03-10',
            ],
            'gender' => [
                'description' => 'Kjønn (M/F/X).',
                'example' => 'F',
            ],
            'club_id' => [
                'description' => 'UUID for klubb.',
                'example' => '2d5f1c66-5678-4a0b-8b6e-112233445566',
            ],
            'nationality' => [
                'description' => 'Nasjonalitetskode (ISO3).',
                'example' => 'NOR',
            ],
            'status' => [
                'description' => 'Status (default: active).',
                'example' => 'active',
            ],
        ];
    }
}
