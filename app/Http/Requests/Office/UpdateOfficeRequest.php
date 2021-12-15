<?php

namespace App\Http\Requests\Office;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOfficeRequest extends FormRequest
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
            'name' => ['required' ,'string', 'between:3,20'],
            'lat' => ['required'],
            'lng' => ['required'],
        ];
    }

}
