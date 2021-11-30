<?php

namespace App\Http\Requests\Api\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListCommentRequest extends FormRequest
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
            'commentable_type' => ['required', 'string', Rule::in(config('custom.commentableTypes'))],
            'commentable_id' => ['required', 'numeric' , 'exists:comments,commentable_id'],
        ];
    }
}
