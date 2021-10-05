<?php

namespace App\Http\Requests\Program\Medical\Cases;

use App\Models\Cases;
use Illuminate\Foundation\Http\FormRequest;

class HideMedicalCaseRequest extends FormRequest
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
            'id' => ['required' , 'exists:'.Cases::getTableName().',id'] , 
        ];
    }

}
