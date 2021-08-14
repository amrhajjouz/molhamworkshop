<?php

namespace App\Http\Requests\Api\Donor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class   UpdateDonorRequest extends FormRequest
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
        $user = $this->user();

        return [
            'name' => 'sometimes|string|min:3|max:50',
            'country_code' => 'sometimes|string|exists:countries,code',
            'phone' => ['sometimes', 'unique:donors,phone,' . $user->id, 'regex:/^([0-9\s\-\+\(\)]*)$/', 'starts_with:+,00', 'min:10', 'max:13'],
            'locale' => ['sometimes', Rule::in(['ar', 'en', 'fr', 'de', 'tr', 'es'])],
            'currency' => ['sometimes', Rule::in(['usd', 'eur', 'try', 'sar', 'aed', 'jod'])],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name_required',
            'name.string' => 'name_must_be_string',
            'name.between' => 'name_length_nust_be_between_3_50',
            'country_code.string' => 'country_code_must_be_string',
            'country_code.exists' => 'country_code_does_not_exist',
            'phone.unique' => 'phone_already_exists',
            'phone.regex' => 'invalid_phone',
            'phone.min' => 'phone_must_be_between_10_13',
        ];
    }
}
