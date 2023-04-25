<?php

namespace App\Http\Requests;

use App\Http\Requests\CustomRequest;

class VehicleRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'limit' => 'integer|min:1|max:100',
            'offset' => 'integer|min:0',
        ];
    }
}
