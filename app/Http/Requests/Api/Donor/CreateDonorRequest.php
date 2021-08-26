<?php

namespace App\Http\Requests\Api\Donor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateDonorRequest extends FormRequest
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
            'name' => ['required', 'string', 'between:3,30'],
            'email' => ['required', 'email', 'unique:donors,email'],
            'password' => ['required', 'string', 'between:8,30'],
            'locale' => ['sometimes', Rule::in(['ar', 'en', 'fr', 'de', 'tr', 'es'])],
            'currency' => ['sometimes', Rule::in(['usd', 'eur', 'try', 'sar', 'aed', 'jod'])],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'invalid_donor_name',
            'name.between' => 'invalid_donor_name_length',
            'email.required' => 'invalid_donor_email',
            'email.email' => 'invalid_donor_email',
            'email.unique' => 'donor_email_already_exists',
            'password.required' => 'invalid_donor_password',
            'password.between' => 'invalid_donor_password_length',
            'locale.*' => 'invalid_donor_locale',
            'currency.*' => 'invalid_donor_currency',
        ];
    }
}
