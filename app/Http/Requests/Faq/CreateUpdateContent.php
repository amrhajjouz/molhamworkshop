<?php

namespace App\Http\Requests\Faq;


use App\Common\Base\BaseRequest;
use Illuminate\Validation\Rule;

class CreateUpdateContent extends BaseRequest
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
            $fields = \App\Models\Faq::get_content_fields();


        $rules = [
            'name' => ['required', 'string', Rule::in($fields)],
            'locale' => ['required', Rule::in($locales)],
            'value' => ['required']
        ];

        if ($this->name == 'answer') {
            $rules['value'] = ['required', 'string', 'max:1000'];
        }


        if ($this->name == 'question') {
            $rules['value'] = ['required', 'string', 'between:3,255'];
        }

        return $rules;
    }
}
