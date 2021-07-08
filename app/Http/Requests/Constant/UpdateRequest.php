<?php

namespace App\Http\Requests\Constant;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;


class UpdateRequest extends FormRequest
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
        return [
            'id' => ['required', 'exists:constants'],
            'plaintext' => ['required', 'boolean'],
            'name' => ['required', 'unique:constants,name,'.$this->id],
        ];
    }
}
