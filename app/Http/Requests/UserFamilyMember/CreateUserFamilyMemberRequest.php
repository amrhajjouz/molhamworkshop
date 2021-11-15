<?php

namespace App\Http\Requests\UserFamilyMember;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserFamilyMemberRequest extends FormRequest
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
            'relative_relation' => ['required'],
        ];
    }
}
