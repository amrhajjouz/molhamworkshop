<?php

namespace App\Http\Requests\Blog;


use Illuminate\Foundation\Http\FormRequest;

class UpdateNoteRequest extends FormRequest
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
        $rules = [
            'content' => ['required' , 'between:3,1000']
        ];
        return $rules;
    }
}
