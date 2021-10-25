<?php

namespace App\Http\Requests\TransactionPayment;

use Illuminate\Foundation\Http\FormRequest;

class TransferTransactionRequest extends FormRequest
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
            'from' => ['required', "different:to"],
            'to' => ["required", "different:from"],
            'amount' => ["required", "numeric", "min:0", "not_in:0"],
            'notes' => ["string"],
        ];
    }
}
