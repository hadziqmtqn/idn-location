<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class ProvinceRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'search' => ['nullable']
        ];
    }

    public function authorize(): true
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse($validator->errors()->first(), null, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
