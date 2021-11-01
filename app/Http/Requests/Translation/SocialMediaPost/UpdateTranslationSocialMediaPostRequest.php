<?php

namespace App\Http\Requests\Translation\SocialMediaPost;

use App\Models\Cases;
use App\Models\Place;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateTranslationSocialMediaPostRequest extends FormRequest
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
        $rules =  [
            'field_name'=>['required' , 'string', 'in:body'] ,
            'locale' => ['required' , 'in:en'] ,
        ];

        if($this->field_name =='body'){
            $rules['value'] = ['required' , 'string' , 'between:1,1000'];
        }
        return $rules;
    }

    public function validated()
    {
        $validated =   [
            $this->field_name => [
                $this->all()['locale'] => [
                    'value' =>  $this->value,
                    'proofread' => false,
                    'auto_generated' => false,
                ],
            ],
        ];
        return  $validated ;
    }
}
