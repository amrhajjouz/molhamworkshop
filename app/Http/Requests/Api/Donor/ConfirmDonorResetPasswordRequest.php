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
            'new_password' => 'required|min:8|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'token.*' => 'invalid_token',
            'new_password.*' => 'invalid_password',
        ];
    }
}
