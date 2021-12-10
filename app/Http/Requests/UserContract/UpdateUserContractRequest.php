<?php

namespace App\Http\Requests\UserContract;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserContractRequest extends FormRequest
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
            'contract_type' => ['required', 'string'],
            'contract_start_date' => ['required', 'date'],
            'contract_end_date' => ['required' ,'date', 'after:contract_start_date'],
            //'job_title' => ['required', 'string'],
            'job_title_id' => ['required', 'numeric' , 'exists:job_titles,id'],
            'workplace' => ['required', 'string'],
            'office_id' => ['string', 'nullable', 'sometimes', 'exists:team_offices,id'],
            'salary' => ['required'],
            'working_hours' => ['required'],
        ];
    }
}
