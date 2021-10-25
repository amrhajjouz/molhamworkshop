<?php

namespace App\Http\Requests\Receiver\Transaction;

use App\Http\Controllers\ReceiverTransactionController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTransactionRequest extends FormRequest
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
            'from' => ['required', 'exists:r_accounts,id', "different:to"],
            'to' => ['required', 'exists:r_accounts,id', "different:from"],
            'type' => ['required', Rule::In(ReceiverTransactionController::TypeList())],
            'amount' => ['numeric', "gt:0"],
            'notes' => ["string"],
        ];
    }
}
