<?php

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProvinceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string']
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

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validasi gagal.',
            'errors' => $validator->errors()
        ], 422));
    }
}
