<?php

namespace App\Http\Requests\Target\Campaign;


use App\Common\Base\BaseRequest;
use Illuminate\Validation\Rule;

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
    public function rules()
    {
        
        return [
            'id' => ['required', 'exists:campaigns'],
            'name' => ['required' ,'string', 'between:3,100'],
            'funded' => ['required'],
            'target' => ['required' , 'array'],
            'places' => ['nullable', 'array'],
        ];
    }


    
}
