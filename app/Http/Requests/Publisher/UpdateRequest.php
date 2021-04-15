<?php

namespace App\Http\Requests\Publisher;

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
            'id' => ['required', 'exists:publishers'],
            'contents' => ['required', 'array'],
            'contents.name.ar' => ['required', 'string'],
            'contents.description.ar' => ['required', 'string'],
        ];
    }
    
}