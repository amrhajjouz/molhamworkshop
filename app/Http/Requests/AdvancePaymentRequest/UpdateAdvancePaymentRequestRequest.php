<?php

namespace App\Http\Requests\AdvancePaymentRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdvancePaymentRequestRequest extends FormRequest
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
            'percentage_to_salary' => ['required'],
            'status' => ['required'],
            'details' => ['required', 'string'],
        ];
    }
}
