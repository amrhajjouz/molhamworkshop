<?php

namespace App\Http\Requests\Shortcut;


use App\Common\Base\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateKeyword extends BaseRequest
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
            'id' => ['required', 'exists:contents'],
            'contentable_id' => ['required', 'exists:shortcuts,id'],
            'name' => ['required'],
            'value' => ['required'],
            'locale' => ['required'],
        ];

        return $rules;
    }
}
