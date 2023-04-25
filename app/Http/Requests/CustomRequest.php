<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CustomRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            ['message' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

}
