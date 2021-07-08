<?php

namespace App\Http\Requests\Constant;


use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
            $fields = \App\Models\Constant::get_content_fields();

        $rules = [
            'name' => ['required', 'string', Rule::in($fields)],
            'locale' => ['required', Rule::in($locales)],
            'value' => ['required']
        ];

        if ($this->name == 'body') {
            $rules['value'] = ['required', 'string', 'max:1000'];
        }




        return $rules;
    }
}
