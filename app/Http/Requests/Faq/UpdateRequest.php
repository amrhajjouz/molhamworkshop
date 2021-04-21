<?php

namespace App\Http\Requests\Faq;

use App\Common\Base\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;


class UpdateRequest extends BaseRequest
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

        // $locales = config('general.available_locales');
        // $fields = \App\Models\Faq::get_content_fields();
        
        // foreach ($fields  as $key => $field) {
        //     foreach ($locales  as $locale) {
        //         $rules['contents.'.  $field]  = ['array'];
        //         $rules['contents.'.  $field . '.' . $locale]  = ['nullable'];
        //     }
        // }
        $rules['category_id'] = ['required'];

        return $rules;
    }
}
