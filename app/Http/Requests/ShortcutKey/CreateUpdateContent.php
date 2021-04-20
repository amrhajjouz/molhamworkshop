<?php

namespace App\Http\Requests\ShortcutKey;


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
        $fields = \App\Models\ShortcutKey::get_content_fields();


        $rules = [
            'name' => ['required', 'string', Rule::in($fields)],
            'locale' => ['required', Rule::in($locales)],
            'value' => ['required' , 'between:3,100']
        ];


        return $rules;
    }
    
}