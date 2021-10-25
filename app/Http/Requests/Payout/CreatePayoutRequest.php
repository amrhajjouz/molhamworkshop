<?php

namespace App\Http\Requests\Payout;

use Illuminate\Foundation\Http\FormRequest;

class CreatePayoutRequest extends FormRequest
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
            'amount' => ['required', "numeric", "min:0", "not_in:0"],
            'currency' => ["required", 'exists:currencies,code'],
            'country_id' => ['required', 'exists:countries,id'],
            'purpose_type' => ['required'],//todo exists in
            'assignee_id' => ["required", 'exists:users,id'],
            'details' => ['string', "nullable"],
        ];
    }
}
