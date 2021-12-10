<?php

namespace App\Http\Requests\UserWorkExperience;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserWorkExperienceRequest extends FormRequest
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
            'employer' => ['required', 'string'],
            'job_title' => ['required', 'string'],
        ];
    }
}
