<?php

namespace App\Http\Requests\Translation\SocialMediaPost;

use App\Models\Cases;
use App\Models\Place;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateTranslationSocialMediaPostRequest extends FormRequest
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
            'locale' => ['required' , Rule::in(['en'])],
            'body' => ['required', 'string', 'between:3,100'],
        ];
    }
    public function validated()
    {
        return  [
            'body' => [
                'en' => [
                    'value' =>  $this->body,
                    'proofread' => false,
                    'auto_generated' => false,
                ],
            ],
        ];
    }

}
