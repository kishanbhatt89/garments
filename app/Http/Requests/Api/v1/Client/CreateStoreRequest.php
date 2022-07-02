<?php

namespace App\Http\Requests\Api\v1\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator; 

class CreateStoreRequest extends FormRequest
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
            'name' => 'required|string|unique:stores',
            'type' => 'required|integer|exists:types,id',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|integer|exists:states,id',
            'zipcode' => 'required|string',
            'gst' => 'nullable|string'            
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([            
            'msg'   => 'Validation errors',
            'status'   => false,            
            'data'      => collect($validator->errors()->getMessages())->map(function($attribute, $key){
                return $attribute[0];
            })
        ], 200));
    }

}
