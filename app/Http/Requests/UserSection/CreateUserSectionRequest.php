<?php

namespace App\Http\Requests\UserSection;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserSectionRequest extends FormRequest
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
            'section_name.ar' => ['required', 'string'],
            'section_name.en' => ['required', 'string'],
            'user_manager_id' => ['required', 'numeric' , 'exists:users,id'],
            'parent_id' => ['required', 'numeric' ,'exists:user_sections,id'],
        ];
    }
}
