<?php

namespace App\Http\Requests\Section;

use Illuminate\Foundation\Http\FormRequest;

class CreateSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('donors.create');;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required' ,'array'],
            'name.ar' => ['required' ,'string' , 'between:3,30'],
            'name.en' => ['required' ,'string' , 'between:3,30'],
            'parent_id' => ['required', 'exists:sections,id'],
        ];
    }
}
