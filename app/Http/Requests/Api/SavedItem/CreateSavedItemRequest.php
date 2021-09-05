<?php

namespace App\Http\Requests\Api\SavedItem;

use Illuminate\Foundation\Http\FormRequest;

class CreateSavedItemRequest extends FormRequest
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
            'saveable_type' => ['required', 'string', 'between:3,30'],
            'saveable_id' => ['required', 'numeric'],
        ];
    }
}
