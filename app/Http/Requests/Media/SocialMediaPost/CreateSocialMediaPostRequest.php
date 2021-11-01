<?php

namespace App\Http\Requests\Media\SocialMediaPost;

use App\Models\Category;
use App\Models\Place;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CreateSocialMediaPostRequest extends FormRequest
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
            'description' => ['required', 'string', 'between:3,255'],
            'body' => ['required', 'string', 'between:3,1000'],
        ];
    }

    public function validated()
    {
        return  [
            'body' => [
                'ar' => [
                    'value' =>  $this->body,
                    'proofread' => false,
                    'auto_generated' => false,
                ],
            ],
            'description'=>$this->description 
        ];
    }

}
