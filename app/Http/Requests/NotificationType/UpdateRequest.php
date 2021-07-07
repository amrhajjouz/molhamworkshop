<?php

namespace App\Http\Requests\NotificationType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // return auth()->user()->can('events.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'exists:notifications_types'],
            'name' => ['required', 'string', 'between:3,50' , 'unique:notifications_types,name,'.$this->id],
            'body_ar' => ['required', 'string'],
            'body_en' => ['required', 'string'],
            'path' => ['nullable', 'string'],
        ];
    }
}
