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
            'code' => 'required|string|exists:donor_reset_password_requests,code',
            'new_password' => 'required|between:8,30|confirmed|string'
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'invalid_donor_reset_password_token',
            'code.exists' => 'donor_reset_password_token_does_not_exists',
            'code.string' => 'invalid_donor_reset_password_token',
            'new_password.required' => 'invalid_new_password',
            'new_password.confirmed' => 'new_password_not_confirmed',
            'new_password.string' => 'invalid_new_password',
            'new_password.between' => 'invalid_new_password_length',
        ];
    }
}
