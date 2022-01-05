<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
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
            'id' => ['required', 'exists:users'],
            'email' => ['email', Rule::unique('users', 'email')->ignore($this->input('id'))],
            'first_name.ar' => ['required', 'string'],
            'first_name.en' => ['required', 'string'],
            'last_name.ar' => ['required', 'string'],
            'last_name.en' => ['required', 'string'],
            'father_name.ar' => ['required', 'string'],
            'father_name.en' => ['required', 'string'],
            'mother_name.ar' => ['required', 'string'],
            'mother_name.en' => ['required', 'string'],
        ];
    }
    
}