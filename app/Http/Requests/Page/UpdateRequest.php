<?php

namespace App\Http\Requests\Page;

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
            'id' => ['required', 'exists:pages'],
            'url' => ['required', 'string'],
        ];
    }
    
}