<?php

namespace App\Http\Requests\Blog;


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
            $fields = \App\Models\Blog::get_content_fields();


            foreach ($fields  as $key => $field) {
                $rules[$field]  = ['array'];
                foreach ($locales  as $locale) {
                    $rules[$field . '.' . $locale]  = ['nullable'];
                }
            }

        return $rules;
    }
}
