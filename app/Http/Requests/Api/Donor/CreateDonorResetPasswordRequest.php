<?php

namespace App\Http\Requests\Api\Donor;

use Illuminate\Foundation\Http\FormRequest;


class CreateDonorResetPasswordRequest extends FormRequest
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
        return ['email' => 'required|email|exists:donors,email'];
    }

    public function messages()
    {
        return ['email.*' => 'invalid_email'];
    }
}
