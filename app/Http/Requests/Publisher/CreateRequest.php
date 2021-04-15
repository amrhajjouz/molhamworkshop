<?php

namespace App\Http\Requests\Publisher;

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
            'contents' => ['required', 'array'],
            'contents.name.ar' => ['required', 'string'],
            'contents.description.ar' => ['required', 'string'],
        ];
    }


    
    
}