<?php

namespace App\Http\Requests\ApiError;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateApiErrorRequest extends FormRequest
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
            'status' => ['nullable' ,'integer' , 'between:100,900'],
            'code' => ['required', 'string', 'unique:api_errors,code'],
            'message' => ['required', 'array'],
            'message.ar' => ['required' , 'string' , 'between:3 , 500'] , 
            'message.en' => ['required' , 'string' , 'between:3 , 500'] , 
        ];
    }
    
}