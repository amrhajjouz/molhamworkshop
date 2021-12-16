<?php

namespace App\Http\Requests\Api\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CreateCommentRequest extends FormRequest
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
            'commentable_id' => ['required', 'numeric'],
            'body' => ['required', 'string' , 'max:1024'],
        ];
    }


    protected function prepareForValidation()
    {
        if (!$this->has('commentable_type') || !in_array($this->commentable_type , config('custom.commentableTypes'))) throw ValidationException::withMessages(['commentable_type' => 'invalid commentable type']);
        getMorphedModel($this->commentable_type)::findOrFail($this->commentable_id);
    }
}
