<?php

namespace App\Http\Requests\Target\Campaign;

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
        // dd($this->all());
        return [
            'name' => ['required' ,'string', 'between:3,100'],
            'places_ids' => ['required', 'array'],
            'target' => ['required' ,'array'],
            'target.beneficiaries_count' => ['required', 'numeric', 'min:1'],
            'target.required' => ['required', 'numeric', 'min:1'],
            'target.section_id' => ['required', 'numeric'],
            'target.required' => ['required' ,'numeric'],
            'target.visible' => ['required' ,'boolean'],
            'admins_ids' => ['nullable', 'array'], // for adminable model
        ];
    }
    
}