<?php

namespace App\Http\Requests\Target\Campaign;


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

        $locales = config('general.available_locales');
        $fields = \App\Models\Campaign::get_content_fields();
        
        
        foreach($fields  as $key => $field){
                foreach($locales  as $locale){
                        $rules[$field]  = ['array' ];
                        $rules[$field.'.'.$locale]  = ['nullable' ];
                    }
                }
                
        return $rules;
    }
    
}