<?php

namespace App\Http\Requests\Publishing\Cases;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePublishingCaseContentsRequest extends FormRequest
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
            'locale' => ['required' , Rule::in(['ar' , 'en' , 'fr' , 'de' , 'tr' , 'es'])],
            'title' => ['required', 'string', 'between:3,100'],
            'description' => ['required', 'string', 'between:3,1000'],
            'details' => ['required', 'string', 'between:3,1000'],
        ];
    }
    public function validated()
    {
        return  [
            'title' => [
                'ar' => [
                    'value' =>  $this->title,
                    'proofread' => false,
                    'auto_generated' => false,
                ],
            ],
            'description' => [
                'ar' => [
                    'value' =>  $this->description,
                    'proofread' => false,
                    'auto_generated' => false,
                ],
            ],
            'details' => [
                'ar' => [
                    'value' =>  $this->details,
                    'proofread' => false,
                    'auto_generated' => false,
                ],
            ],
        ];
    }

}
