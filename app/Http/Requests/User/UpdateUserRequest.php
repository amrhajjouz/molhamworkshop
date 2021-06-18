<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  auth()->user()->super_admin;
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
            'name' => ['string', 'between:3,20'],
            'email' => ['email', Rule::unique('users', 'email')->ignore($this->input('id'))],
            'password' => ['string', 'min:8'],
        ];
    }
    
}