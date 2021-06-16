<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UnassignPermissionRequest extends FormRequest
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
        return [
            'permission_id' => ['required' ,'exists:permissions,id'],
            'user_id' => ['required' ,'exists:users,id'],
        ];
    }
}
