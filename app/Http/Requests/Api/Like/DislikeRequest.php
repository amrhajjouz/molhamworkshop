<?php

namespace App\Http\Requests\Api\Like;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DislikeRequest extends FormRequest
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
            'likeable_type' => ['required', 'string', Rule::in(config('custom.likeableTypes'))],
            'likeable_id' => ['required', 'numeric'],
        ];
    }


    protected function prepareForValidation()
    {
        if (!$this->has('likeable_type') || !in_array($this->likeable_type , config('custom.likeableTypes'))) throw ValidationException::withMessages(['likeable_type' => 'invalid likeable type']);
        getMorphedModel($this->likeable_type)::findOrFail($this->likeable_id);
    }
}
