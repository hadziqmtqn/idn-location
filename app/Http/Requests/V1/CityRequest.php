<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'q' => ['nullable'],
            'province' => ['required', 'string', 'exists:indonesia_provinces,name']
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
            'province' => 'provinsi'
        ];
    }
}
