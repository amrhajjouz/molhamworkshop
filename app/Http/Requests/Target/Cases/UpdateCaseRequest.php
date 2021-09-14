<?php

namespace App\Http\Requests\Target\Cases;

use App\Models\Cases;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCaseRequest extends FormRequest
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
            'id' => ['required', 'exists:'.Cases::getTableName()],
            'beneficiary_name' => ['required' ,'string', 'between:3,100'],
            'country_code' => ['required' ,'string' , 'exists:countries,code'],
            'target' => ['required' ,'array'],
            'target.beneficiaries_count' => ['required' ,'numeric', 'min:1'],
            'target.required' => ['required' ,'numeric' , 'min:1'],
            'target.archived' => ['required' ,'boolean'],
            'target.documented' => ['required' ,'boolean'],
            'target.hidden' => ['required' ,'boolean'],
            'status' => ['required' , Rule::in(['funded' , 'unfunded' , 'canceled','spent'])],
        ];
    }
    
}