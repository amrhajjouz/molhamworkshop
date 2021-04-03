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
            'donor_id' => ['required', 'numeric'],
            'target' => ['array', 'array'],
            'target.required' => ['required', 'numeric', 'min:1'],
            'target.visible' => ['required', 'boolean'],
            'target.section_id' => ['required', 'numeric'],
            'admins_ids' => ['nullable', 'array'], // for adminable model
        ];
    }


    
    
}