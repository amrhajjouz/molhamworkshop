<?php

namespace App\Http\Requests\Target\Fundraiser;

use Illuminate\Validation\Rule;
use App\Common\Base\BaseRequest;

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
            'public_visibility' => ['required' , 'boolean'],
            'verified' => ['required' , 'boolean'],
            'target' => ['required' , 'array'],
            'donor_id' => ['required', 'numeric'],
        ];
    }


    
    
}