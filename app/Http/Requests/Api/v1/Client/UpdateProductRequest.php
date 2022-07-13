<?php

namespace App\Http\Requests\Api\v1\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateProductRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'details' => 'sometimes|string',            
            'category_id' => 'sometimes|exists:categories,id',
            'subcategory_id' => 'sometimes|exists:categories,id',
            'variation_type' => 'sometimes|string|in:single,multiple',
            'status' => 'sometimes|string',
            'sku' => 'sometimes|string|unique:products,sku,'.$this->id,
            'brand' => 'sometimes|string'
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
