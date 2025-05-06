<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class DistrictRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'q' => ['nullable'],
            'city' => ['required', 'string', 'exists:indonesia_cities,name']
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
            'city' => 'kota/kabupaten'
        ];
    }
}
