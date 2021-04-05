<?php

namespace App\Http\Requests\Target\Cases;


use App\Common\Base\BaseRequest;
use Illuminate\Validation\Rule;

class CreateUpdateContent extends BaseRequest
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


        return [
            // 'id' => ['required', 'exists:cases'],
            'title' => ['required' , 'array'],
            'title.ar' => ['required', 'string'],
            'details.ar' => ['required', 'string'],
            'title.en' => ['required', 'string'],
            'details.en' => ['required', 'string'],
        ];
    }
    
}