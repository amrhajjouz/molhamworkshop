<?php

namespace App\Http\Requests\TransactionPayment;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
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
            'notes' => ['string', 'nullable'],
            'payment_method' => ["required", 'string'],//todo exists in
            'received_at' => ["required", 'date'],
            'usd_rate' => ["required", "numeric", "min:0", "not_in:0"],
            'language' => ["required", 'string'],//todo exists in
            'donor_id' => ["required", 'exists:donors,id'],
            'currency' => ["required", 'exists:currencies,code'],
            'account_id' => ["required", 'exists:r_accounts,id'],
            'country_id' => ['required', 'exists:countries,id'],
            'purposes' => ['required', 'array', "min:1"],
            'purposes.*.amount' => ['required', "numeric", "min:0", "not_in:0"],
            'purposes.*.purpose_type' => ['required'],//todo exists in
        ];
    }

    public function messages(): array
    {
        return [
            'purposes.required' => "مطلوب",
            'purposes.*.amount' => ['required', "numeric", "min:0", "not_in:0"],
            'purposes.*.purpose_type' => ['required'],
        ];
    }
}
