<?php

namespace App\Http\Requests\Publisher;


use App\Common\Base\BaseRequest;
use Illuminate\Validation\Rule;

class ListContentRequest extends BaseRequest
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
        $fields = \App\Models\Publisher::get_content_fields();

        $rules =[
            'field' => ['sometimes'  , Rule::in($fields)] ,
            'locale' => ['sometimes' , Rule::in($locales)] ,
            'trashed'=>['sometimes' ]
        ];


        return $rules;
    }
}
