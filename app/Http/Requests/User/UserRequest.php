<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => ['required' ,'string', 'between:3,20'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ];

        if (in_array($this->method(), ['PUT'])) {

            $rules = [
                'id' => ['required', 'exists:users'],
                'name' => ['string', 'between:3,20'],
                'email' => ['email', Rule::unique('users', 'email')->ignore($this->input('id'))],
                'password' => ['string', 'min:8'],
            ];

        }//end of if

        return $rules;

    }
    
}