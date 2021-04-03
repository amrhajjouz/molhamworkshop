<?php

namespace App\Http\Requests\Target\Fundraiser;

use App\Common\Base\BaseRequest;

class UpdateRequest extends BaseRequest
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
    // required
    public function rules()
    {
        return [
            'id' => ['required', 'exists:fundraisers'],
            'public_visibility' => ['required' , 'boolean'],
            'verified' => ['required' , 'boolean'],
            'donor_id' => ['required', 'numeric'],
            'target' => ['required', 'required'],
            'target.required' => ['required', 'numeric', 'min:1'],
            'target.visible' => ['required', 'boolean'],
            'target.documented' => ['required', 'boolean'],
            'target.archived' => ['required', 'boolean'],
            'target.section_id' => ['required', 'numeric'],
            'admins_ids' => ['nullable', 'array'], // for adminable model
        ];
    }
    
}