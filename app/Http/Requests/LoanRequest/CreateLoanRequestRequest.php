<?php

namespace App\Http\Requests\LoanRequest;

use Illuminate\Foundation\Http\FormRequest;

class CreateLoanRequestRequest extends FormRequest
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
            'amount' => ['required' ,'numeric'],
            'receiving_date' => ['required' ,'date'],
            'return_date' => ['required' ,'date'],
            'details' => ['required', 'string'],
        ];
    }
}
