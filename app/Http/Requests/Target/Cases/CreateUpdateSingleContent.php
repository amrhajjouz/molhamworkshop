<?php

namespace App\Http\Requests\Target\Cases;


use App\Common\Base\BaseRequest;
use Illuminate\Validation\Rule;

class CreateUpdateSingleContent extends BaseRequest
{


    // protected function prepareForValidation()
    // {
    //     // $this->merge(['id' => [$this->id]]);

    // }

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
            'id' => ['nullable' , 'exists:contents'] ,
            'contentable_id' => ['required' , 'exists:cases'] ,
            'value' => ['required' , 'string'] ,
            'name' => ['required' , 'string'] ,
        ];

        return $rules;
    }
    
}