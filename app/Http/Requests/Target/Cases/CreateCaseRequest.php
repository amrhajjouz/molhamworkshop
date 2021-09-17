<?php

namespace App\Http\Requests\Target\Cases;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCaseRequest extends FormRequest
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
            'beneficiary_name' => ['required' ,'string', 'between:3,100'],
            'country_code' => ['required' ,'string' , 'exists:countries,code'],
            'target' => ['required' ,'array'],
            'target.beneficiaries_count' => ['required' ,'numeric', 'min:1'],
            'target.required' => ['required' ,'numeric' , 'min:1'],
            'target.hidden' => ['required' ,'boolean'],
            'status' => ['required' , Rule::in(['funded' , 'unfunded' , 'canceled','spent'])],
            'place_id' => ['required' , 'exists:places,id'],
        ];
    }



    //TODO : place->country_code ;
    // prpareForValidation
    // sy , lb => lebanon , tr , jo => jordon , eg
    
}