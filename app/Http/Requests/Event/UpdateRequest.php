<?php

namespace App\Http\Requests\Event;

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
        return auth()->user()->can('events.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'exists:events'],
            'name' => ['required', 'string', 'between:3,50' , 'unique:events,name,'.$this->id],
            'body_ar' => ['required', 'string'],
            'body_en' => ['required', 'string'],
        ];
    }
}
