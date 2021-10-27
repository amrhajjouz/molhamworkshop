<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateMemberRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:users,email'],
            'job_title' => ['required' ,'string'],
            'contract_type' => ['required' ,'string'],
            'contract_starting_date' => ['required' ,'date'],

        ];
    }
    
}