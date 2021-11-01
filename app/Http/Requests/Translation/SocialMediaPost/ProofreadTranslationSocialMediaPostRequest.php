<?php

namespace App\Http\Requests\Translation\SocialMediaPost;

use App\Models\SocialMediaPost;
use Illuminate\Foundation\Http\FormRequest;

class ProofreadTranslationSocialMediaPostRequest extends FormRequest
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
            'id' => ['required' , 'exists:'.SocialMediaPost::getTableName() . ',id']
        ];
    }

}
