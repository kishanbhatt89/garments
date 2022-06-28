<?php

namespace App\Http\Requests\Api\v1\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ProductImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:products,id',
            'image' =>  'required|image:jpeg,png,jpg,gif,svg',
        ];
    }

    public function failedValidation(Validator $validator) {

        throw new HttpResponseException(response()->json([            
            'msg'   => 'Validation errors',
            'status'   => false,            
            'data'      => $validator->messages()->all()
        ], 200));
    }

}
