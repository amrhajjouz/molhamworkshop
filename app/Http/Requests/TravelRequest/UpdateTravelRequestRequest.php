<?php

namespace App\Http\Requests\TravelRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTravelRequestRequest extends FormRequest
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
            'return_date' => ['required' ,'date', 'after:receiving_date'],
            'status' => ['required'],
            'details' => ['required', 'string'],
        ];
    }
}
