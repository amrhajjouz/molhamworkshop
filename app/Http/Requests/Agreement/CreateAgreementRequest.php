<?php

namespace App\Http\Requests\Agreement;

use Illuminate\Foundation\Http\FormRequest;

class CreateAgreementRequest extends FormRequest
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
            'currency' => ["required", 'exists:currencies,code'],
            'title' => ['required', 'string', 'between:3,30'],
            'amount' => ['required', "numeric", "min:0", "not_in:0"],
            'admin_costs_percentage' => ['required', "numeric", "min:0"],
            'details' => ['required', 'string'],
            'starting_date' => ['required', 'date'],
            'ending_date' => 'required|date|after:starting_date',
        ];
    }
}
