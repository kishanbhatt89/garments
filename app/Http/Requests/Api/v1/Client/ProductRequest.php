<?php

namespace App\Http\Requests\Api\v1\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator; 

class ProductRequest extends FormRequest
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
            'sku' => 'required|string|max:255|unique:products',
            'name' => 'required|string|max:255',
            'details' => 'required|string',
            'brand' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:categories,id',
            'variation_type' => 'required|string|in:single,multiple',
            'status' => 'required'            
        ];
    }

    public function failedValidation(Validator $validator) {

        throw new HttpResponseException(response()->json([            
            'msg'   => 'Validation errors',
            'status'   => false,            
            'data'      => collect($validator->errors()->getMessages())->map(function($attribute, $key){
                return $attribute[0];
            })
        ], 200));
    }

}
