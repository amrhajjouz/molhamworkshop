<?php

namespace App\Http\Requests\Target\Cases;

use App\Models\Cases;
use Illuminate\Foundation\Http\FormRequest;

class UnhideCaseRequest extends FormRequest
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
