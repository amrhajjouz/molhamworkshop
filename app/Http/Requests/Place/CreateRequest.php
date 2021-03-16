<?php

namespace App\Http\Requests\Place;

use Illuminate\Validation\Rule;
use App\Common\Base\BaseRequest;
use App\Models\Country;
use Illuminate\Validation\Rules\RequiredIf;

class CreateRequest extends BaseRequest
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
            'name' => ['required' ,'string', 'between:3,100'],
            'type' => ['required' , Rule::in('province' , 'city' ,'village' , 'district')],
            'parent_id' => ['nullable' ,'numeric'],
            'country_id' => ['nullable' ,'numeric' , new RequiredIf($this->type == 'province')],
            
            
        ];
    }
    
}