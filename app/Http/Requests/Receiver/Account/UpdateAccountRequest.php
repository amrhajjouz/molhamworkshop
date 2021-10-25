<?php

namespace App\Http\Requests\Receiver\Account;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
            'name' => ['required', 'string', 'between:3,30'],
            'initial_balance' => ['required', 'min:0', 'numeric'],
            'type_id' => ['required', 'exists:r_accounts_types,id']
        ];
    }
}
