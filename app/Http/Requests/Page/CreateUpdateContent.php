<?php

namespace App\Http\Requests\Page;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUpdateContent extends FormRequest
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
        $locales = config('general.available_locales');
        $fields = \App\Models\Page::get_content_fields();
        $rules = [
            'name' => ['required', 'string', Rule::in($fields)],
            'locale' => ['required', Rule::in($locales)],
            'value' => ['required']
        ];

        if ($this->name == 'description') {
            $rules['value'] = ['required', 'string', 'max:1000'];
        }
       
        if ($this->name == 'body') {
            $rules['value'] = ['required', 'string', 'max:1000'];
        }

        if ($this->name == 'title') {
            $rules['value'] = ['required', 'string', 'between:3,100'];
        }

        return $rules;
    }
    
}