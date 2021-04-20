<?php

namespace App\Http\Requests\ShortcutKey;


use App\Common\Base\BaseRequest;
use Illuminate\Validation\Rule;

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
        // dd($this->all());
        $rules = [

            'shortcut_id' => ['required' , 'exists:shortcuts,id'],
            'name' => ['required'],
            'locale' => ['required'],
            'value' => ['required'],
        ];

        return $rules;
    }
}
