<?php

namespace App\Http\Requests\Api\v1\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator; 

class UpdateStoreRequest extends FormRequest
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
            'name' => 'sometimes|string|unique:stores,name,'.auth('client')->user()->store->id,
            'type' => 'sometimes|integer|exists:types,id',
            'description' => 'sometimes|nullable|string',
            'address' => 'sometimes|string',
            'city' => 'sometimes|integer|exists:cities,id',
            'state' => 'sometimes|integer|exists:states,id',
            'zipcode' => 'sometimes|string',
            'gst' => 'sometimes|nullable|string'            
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
