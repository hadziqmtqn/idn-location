<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class ProvinceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'q' => ['nullable']
        ];
    }

    public function authorize(): true
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'q' => 'pencarian'
        ];
    }
}
