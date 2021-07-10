<?php

namespace App\Http\Requests\Shortcut;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
        
        $rules = [

            'path' => ['required' , 'string'],
            'contents' => ['required' , 'array'],
            'contents.title' => ['required' , 'array'],
            'contents.description' => ['required' , 'array'],
            'contents.title.value' => ['required' , 'string'],
            'contents.description.value' => ['required' , 'string'],
        ];
        return $rules;
    }
    
}