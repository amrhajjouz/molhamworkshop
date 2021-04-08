<?php

namespace App\Http\Requests\Faq;

use Illuminate\Validation\Rule;
use App\Common\Base\BaseRequest;
use App\Models\Country;
use Illuminate\Validation\Rules\RequiredIf;

class CreateRequest extends BaseRequest
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
        // dd($this->all());

        // foreach ($fields  as $key => $field) {
        //     foreach ($locales  as $locale) {
        //         $rules[$locale]  = ['array'];
        //         $rules[ $locale . '.' . $field . '.value']  = ['nullable'];
        //         $rules[ $locale . '.' . $field . '.name']  = ['nullable'];
        //         $rules[ $locale . '.' . $field . '.locale']  = ['nullable'];
        //     }
        // }
        // dd($this->all() , $locales , $fields , $rules);

        foreach ($fields  as $key => $field) {
            foreach ($locales  as $locale) {
                $rules['contents.' .  $field]  = ['array'];
                $rules['contents.' .  $field . '.' . $locale]  = ['nullable'];
            }
        }
        $rules['category_id'] =['required'];
        // dd($rules , $this->all());
        return $rules;
    }
    
}