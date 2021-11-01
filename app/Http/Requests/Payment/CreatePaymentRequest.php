<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
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
            'notes' => ['string', 'nullable'],
            'received_at' => ["required", 'date'],
            'reference' => ["required"],
            'fx_rate' => ["required", "numeric", "min:0", "not_in:0"],
            'donor_id' => ["required", 'exists:donors,id'],
            'account_id' => ["required", 'exists:accounts,id'],
            'country_code' => ['required', 'exists:countries,code'],
            'purposes' => ['required', 'array', "min:1"],
            'purposes.*.amount' => ['required', "numeric", "min:0", "not_in:0"],
            'purposes.*.purpose_id' => ['required', 'exists:purposes,id'],
            'purposes.*.deduction_ratio_id' => ['required', 'exists:deduction_ratios,id'],
        ];
    }
}
