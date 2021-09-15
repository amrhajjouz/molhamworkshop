<?php

namespace App\Http\Requests\Place;

use App\Models\Place;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Validation\ValidationException;

class CreatePlaceRequest extends FormRequest
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
            'name' => ['required', 'array'],
            'name.ar' => ['required', 'string', 'between:3,30'],
            'name.en' => ['required', 'string', 'between:3,30'],
            'parent_id' => ['required', 'numeric' , 'exists:places,id'],
        ];
    }

}
