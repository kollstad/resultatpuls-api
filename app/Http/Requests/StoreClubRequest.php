<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClubRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'        => ['required','string','max:255'],
            'short_name'  => ['nullable','string','max:50'],
            'district_id' => ['required','uuid','exists:districts,id'],
            'wa_code'     => ['nullable','string','max:50'],
            'org_no'      => ['nullable','string','max:50'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Navn på klubb.',
                'example' => 'Kristiansand IF Friidrett',
            ],
            'short_name' => [
                'description' => 'Forkortelse.',
                'example' => 'KIF',
            ],
            'district_id' => [
                'description' => 'UUID for kretsen klubben tilhører.',
                'example' => '1c3b2a2e-1234-4bcd-9d8f-0a1b2c3d4e5f',
            ],
            'wa_code' => [
                'description' => 'World Athletics-kode (valgfri).',
                'example' => 'NOR-KIF',
            ],
            'org_no' => [
                'description' => 'Organisasjonsnummer (valgfri).',
                'example' => '999999999',
            ],
        ];
    }
}
