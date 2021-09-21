<?php

namespace App\Http\Requests\Human;

use Illuminate\Foundation\Http\FormRequest;

class CreateHumanRequest extends FormRequest
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
            'name' => ['required' ,'string'],
            'last_name' => ['required' ,'string'],
            'father' => ['required' ,'string'],
            'mother' => ['required' ,'string'],
            'email' => ['required', 'email', 'unique:humans,email'],
        ];
    }
}
