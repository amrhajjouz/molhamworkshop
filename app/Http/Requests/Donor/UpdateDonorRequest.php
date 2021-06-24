<?php

namespace App\Http\Requests\Donor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDonorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        return $user->can('donors.update');;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required' ,'string', 'between:3,30'],
            'email' => ['required' , 'email' , 'unique:donors,email,'.$this->input('id')],
            'password' => ['string', 'min:8'],
            'phone' => ['string', 'between:5,20'],
            'whatsapp_number' => ['string', 'between:5,20'],
            'swish_number' => ['string', 'max:20'],
        ];
    }
}
