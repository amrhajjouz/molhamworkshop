<?php

namespace App\Http\Requests\Api\Donor;

use Illuminate\Foundation\Http\FormRequest;

class CreateDonorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'name' => ['required', 'string', 'between:3,30'],
            'email' => ['required', 'email', 'unique:donors,email'],
            'password' => ['required', 'string', 'between:8,30'],
        ];
    }

    public function messages(){
        return [
            'name.required'=> 'name_required' ,
            'name.between'=> 'invalid_name_length' ,
            'email.required'=> 'email_required' ,
            'email.email'=> 'invalid_email' ,
            'email.unique'=> 'email_already_exist' ,
            'password.required'=> 'password_required' ,
            'password.between'=> 'the password should be between:8,30' ,
        ];
    }
}
