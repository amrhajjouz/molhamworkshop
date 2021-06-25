<?php

namespace App\Http\Requests\Donor;

use Illuminate\Foundation\Http\FormRequest;

class CreateDonorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->can('donors.create');;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required' ,'string', 'between:3,30'],
            'email' => ['required' , 'email' , 'unique:donors,email'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['string', 'between:5,20'],
            'whatsapp_number' => ['string', 'between:5,20'],
            'swish_number' => ['string', 'max:20'],
        ];
    }
}
