<?php

namespace App\Http\Requests\Api\v1\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator; 

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'phone' => 'required|digits:10|unique:clients',
            'password' => 'required|string|min:6',
        ];
    }

    public function failedValidation(Validator $validator)
    {        
        throw new HttpResponseException(response()->json([            
            'msg'   => 'Validation errors',
            'status'   => false,            
            'data' => collect($validator->errors()->getMessages())->map(function($attribute, $key){
                return $attribute[0];
            })
        ], 200));
    }

}
