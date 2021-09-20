<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name.ar' => ['required', 'string'],
            'name.en' => ['required', 'string'],
            'description.ar' => ['string', 'nullable'],
            'description.en' => ['string', 'nullable'],
            'currency' => ['string', 'nullable', "exists:currencies,code"],
            'country_code' => ['string', 'nullable', "exists:countries,code"],
            'default_deduction_ratio_id' => ['string', 'nullable', "exists:deduction_ratios,id"]
        ];
    }
}
