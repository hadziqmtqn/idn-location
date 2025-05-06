<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class VillageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'q' => ['nullable'],
            'district' => ['required', 'string', 'exists:indonesia_districts,name']
        ];
    }

    public function authorize(): true
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'q' => 'pencarian',
            'district' => 'kecamatan'
        ];
    }
}
