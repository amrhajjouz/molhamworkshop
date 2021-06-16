<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            'id' => ['required' ,'exists:roles'],
            'name' => ['required' ,'string', 'between:3,30' , 'unique:roles,name,'.$this->id],
            'ar_name' => ['required', 'string',],
        ];
    }
}
