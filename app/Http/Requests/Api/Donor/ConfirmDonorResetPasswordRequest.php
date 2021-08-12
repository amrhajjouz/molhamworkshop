<?php

namespace App\Http\Requests\Api\Donor;

use Illuminate\Foundation\Http\FormRequest;


class ConfirmDonorResetPasswordRequest extends FormRequest
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
            'token' => 'required|string|exists:donor_reset_password_requests,token',
            'new_password' => 'required|between:8,30|confirmed|string'
        ];
    }

    public function messages()
    {
        return [
            'token.required' => 'token_required',
            'token.exists' => 'token_does_not_exists',
            'token.string' => 'invalid_token',
            'new_password.required' => 'new_password_required',
            'new_password.confirmed' => 'new_password_must_be_confirmed',
            'new_password.string' => 'invalid_new_password',
            'new_password.between' => 'the password should be between:8,30',
        ];
    }
}
