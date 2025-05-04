<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class DistrictRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'search' => ['nullable'],
            'city_code' => ['required']
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
