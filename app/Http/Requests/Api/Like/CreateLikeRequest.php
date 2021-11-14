<?php

namespace App\Http\Requests\Api\Like;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateLikeRequest extends FormRequest
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
        $likeableModels = ['cases' , 'campaign' , 'sponsorship' , 'project' , 'small_project' , 'scholarshop' , 'fundraiser' ,'event'];
        return [
            'likeable_type' => ['required', 'string', Rule::in($likeableModels)],
            'likeable_id' => ['required', 'numeric'],
        ];
    }
}
