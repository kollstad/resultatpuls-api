<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDistrictRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'code' => ['required','string','max:10','unique:districts,code'],
        ];
    }

    public function bodyParameters(): array
{
    return [
        'name' => [
            'description' => 'Navn på krets.',
            'example' => 'Agder Friidrettskrets',
        ],
        'code' => [
            'description' => 'Kort kode (unik).',
            'example' => 'AAK',
        ],
    ];
}
}
