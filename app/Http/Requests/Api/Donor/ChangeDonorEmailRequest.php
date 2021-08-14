<?php

namespace App\Http\Requests\Api\Donor;

use Illuminate\Foundation\Http\FormRequest;

class ChangeDonorEmailRequest extends FormRequest
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
            'new_email' => "required|email|unique:donors,email," . $this->user()->id
        ];
    }

    public function messages()
    {
        return [
            'new_email.required' => 'invalid_email',
            'new_email.email' => 'invalid_email',
            'new_email.unique' => 'email_already_exists',
        ];
    }
}
