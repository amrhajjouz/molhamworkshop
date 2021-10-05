<?php

namespace App\Http\Requests\Program\Medical\Cases;

use App\Models\Cases;
use App\Models\Place;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateMedicalCaseContentsRequest extends FormRequest
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
            'title' => ['required', 'string', 'between:3,100'],
            'description' => ['required', 'string', 'between:3,1000'],
            'details' => ['required', 'string', 'between:3,1000'],
        ];
    }

    public function validated()
    {
        // $validated = $this->validator->validated();
        return  [
            'title' => [
                'ar' => $this->title , 
            ],
            'description' => [
                'ar' => $this->description , 
            ],
            'details' => [
                'ar' => $this->details , 
            ],
        ];
    }

}
