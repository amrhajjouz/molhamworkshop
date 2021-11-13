<?php

namespace App\Http\Requests\Label;

use Illuminate\Foundation\Http\FormRequest;

class CreateLabelRequest extends FormRequest
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
            'name' => ['required', 'string', 'between:3,30'],
            'color' => ['required', 'string', 'between:3,30'],
            'board_id' => ['required', 'numeric', 'exists:boards,id'],
        ];
    }
}
