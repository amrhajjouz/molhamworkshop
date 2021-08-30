<?php

namespace App\Http\Requests\Place;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;


class UpdatePlaceRequest extends FormRequest
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
            'id' => ['required', 'exists:places'],
            'name' => ['required' ,'string', 'between:3,100'],
            'type' => ['required' , Rule::in('province' , 'city' ,'village' , 'district')],
            'parent_id' => ['nullable' ,'numeric'],
            'country_code' => ['nullable' ,'string' , new RequiredIf($this->type == 'province'), 'exists:countries,code'],
        ];
    }
}