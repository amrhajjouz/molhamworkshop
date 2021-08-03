<?php

namespace App\Http\Requests\Donor;

use Illuminate\Foundation\Http\FormRequest;

class ChangeDonorPasswordRequest extends FormRequest
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
            'new_password' => "required|string|confirmed|between:8,20"
        ];
    }
}
