<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        if ($user->super_admin) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required' , 'exists:permissions'],
            'name' => ['required' ,'string', 'between:3,30' , 'unique:permissions,name,'.$this->id],
            'description_ar' => ['required', 'string',],
            'description_en' => ['required', 'string',],
        ];
    }
}
