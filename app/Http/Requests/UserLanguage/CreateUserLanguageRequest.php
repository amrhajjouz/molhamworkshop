<?php

namespace App\Http\Requests\UserLanguage;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserLanguageRequest extends FormRequest
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
            'language_name' => ['required', 'string'],
            'mother_language' => ['required', 'string'],
            'reading' => ['required', 'string'],
            'writing' => ['required', 'string'],
            'listening' => ['required', 'string'],
        ];
    }
}
