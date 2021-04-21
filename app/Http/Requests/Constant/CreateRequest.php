<?php

namespace App\Http\Requests\Constant;

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

        $request = $this;
        // dd($request->all());
        return [
            'name' => ['required' ,'unique:constants,name'],
            'plaintext' => ['required' ,'boolean'],
            'content' => ['array' ,'required'],
            'content.name' => ['string' ,'required',
            Rule::in(['body'])
        ],
            'content.value' => ['string' ,'required'],
            
            
        ];
    }
    
}