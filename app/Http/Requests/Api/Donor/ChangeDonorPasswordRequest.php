<?php

namespace App\Http\Requests\Api\Donor;


use Illuminate\Foundation\Http\FormRequest;

class ChangeDonorPasswordRequest extends FormRequest
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
        return ['new_password' => "required|string|confirmed|between:8,20"];
    }

    public function messages()
    {
        return [
            'new_password.required' => 'new_password_required',
            'new_password.confirmed' => 'new_password_must_be_confirmed',
            'new_password.string' => 'invalid_new_password',
            'new_password.between' => 'the password should be between:8,30',
        ];
    }
}
