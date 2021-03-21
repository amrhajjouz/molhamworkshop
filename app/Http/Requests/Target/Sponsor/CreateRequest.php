<?php

namespace App\Http\Requests\Target\Sponsor;

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
            'donor_id' => ['required' ,'numeric'],
            'percentage' => ['required' ,'numeric'],
            'purpose_id' => ['required', 'numeric'],
            'purpose_type' => ['required', 'string'],
            
        ];
    }
    
}