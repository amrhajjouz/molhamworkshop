<?php

namespace App\Http\Requests\Target;

use Illuminate\Foundation\Http\FormRequest;

class ArchiveTargetRequest extends FormRequest
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
            'id' => ['required' , 'exists:programs_targets,id'] , 
            'targetable_type' => ['required' , 'string'], 
        ];
    }

}
