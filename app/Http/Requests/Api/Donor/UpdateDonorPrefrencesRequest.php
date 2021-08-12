<?php

namespace App\Http\Requests\Api\Donor;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDonorPrefrencesRequest extends FormRequest
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
            'locale' => ['required', Rule::in(['ar', 'en', 'fr', 'de', 'tr', 'es'])],
            'currency' => ['required', Rule::in(['usd', 'eur', 'try', 'sar', 'aed', 'jod'])],
            'theme_mode' => ['required', Rule::in(['light', 'dark'])],
            'theme_color' => ['required', Rule::in(['primary',  'purple', 'teal'])],
        ];
    }

    public function messages()
    {
        return [
            'locale.*' => 'invalid_locale',
            'currency.*' => 'invalid_currency',
            'theme_mode.*' => 'invalid_theme_mode',
            'theme_color.*' => 'invalid_theme_color',
        ];
    }
}
