<?php

namespace App\Http\Requests\Media\SocialMediaPost;

use App\Models\Cases;
use App\Models\Place;
use App\Models\SocialMediaPost;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProofreadSocialMediaPostRequest extends FormRequest
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
