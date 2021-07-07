<?php

namespace App\Http\Requests\NotificationType;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // return auth()->user()->can('events.create');;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required' ,'string', 'between:3,50' , 'unique:notifications_types'],
            'body_ar' => [ 'required' , 'string'],
            'body_en' => [ 'required' , 'string'],
            'path' => [ 'nullable' , 'string'],
        ];
    }
}
