<?php

namespace App\Http\Requests\UserResidence;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserResidenceRequest extends FormRequest
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
            'residence_type' => ['required' ,'string'],
            'current_residence' => ['required' ,'string'],
        ];
    }
}
