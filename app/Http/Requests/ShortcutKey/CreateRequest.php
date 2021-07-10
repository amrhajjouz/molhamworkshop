<?php

namespace App\Http\Requests\ShortcutKey;


use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
        $rules = [
            'shortcut_id' => ['required' , 'exists:shortcuts,id'],
            'name' => ['required'],
            'locale' => ['required'],
            'value' => ['required'],
        ];

        return $rules;
    }
}
