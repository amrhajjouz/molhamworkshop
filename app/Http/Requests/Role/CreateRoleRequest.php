<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can("*");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required' ,'string', 'between:3,100' ,'unique:roles,name'],
            'title' => ['required' ,'array',],
            'title.en' => ['required' ,'string', 'between:3,30'],
            'title.ar' => ['required' ,'string', 'between:3,30'],
            'has_multiple_assignees' => ['required' , 'boolean'],
            'section_id' => ['required' , 'exists:sections,id'],
        ];
    }
}
