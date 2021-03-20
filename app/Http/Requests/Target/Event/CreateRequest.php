<?php

namespace App\Http\Requests\Target\Event;

use Illuminate\Validation\Rule;
use App\Common\Base\BaseRequest;
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
            'date' => ['required'],
            'public_visibility' => ['required' , 'boolean'],
            'donor_id' => ['required' , 'numeric'],
            'verified' => ['nullable'],
            'implemented' => ['nullable' ,'boolean'],
            'implementation_date' => [new RequiredIf($this->implemented ==true)],
            'youtube_video_url' => ['nullable' ,'string'],
            'target' => ['required' , 'array'],
            'places_ids' => ['required', 'array'],
        ];
    }


    
    
}