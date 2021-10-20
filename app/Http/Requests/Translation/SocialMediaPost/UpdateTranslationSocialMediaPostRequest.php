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
        // dd( $this->body['en']['value']);
        $rules =  [
            // 'locale' => ['required' , Rule::in(['en' , 'ar'])],
            // 'body' => ['required', 'string', 'between:3,100'],
            'body' => ['required', 'array' ],
            'body.ar' => ['required', 'array' ],
            'body.ar.value' => ['required', 'string', 'between:3,100' ],
            'body.en' => ['sometimes', 'array' ],
            'body.en.value' => ['sometimes', 'string', 'between:3,100' ],


            'field_name'=>['required' , 'string', 'in:body'] ,
            'locale' => ['required' , 'in:ar,en'] ,
            
            
        ];


        if($this->field_name =='body'){
            $rules['value'] = ['required' , 'string' , 'between:1,1000'];
        }
    }

    public function validated()
    {
        $validated =   [
            $this->field_name => [
                $this->locale => [
                    'value' =>  $this->body['ar']['value'],
                    'proofread' => false,
                    'auto_generated' => false,
                ],
            ],
        ];
        
        if(isset($this->body['en']['value'])){
            $validated['body']['en'] = [
                'value' =>  $this->body['en']['value'],
                'proofread' => false,
                'auto_generated' => false,
            ];
        }
        return $validated;
    }

    // public function validated()
    // {
    //     $validated =   [
    //         'body' => [
    //             'ar' => [
    //                 'value' =>  $this->body['ar']['value'],
    //                 'proofread' => false,
    //                 'auto_generated' => false,
    //             ],
    //         ],
    //     ];
        
    //     if(isset($this->body['en']['value'])){
    //         $validated['body']['en'] = [
    //             'value' =>  $this->body['en']['value'],
    //             'proofread' => false,
    //             'auto_generated' => false,
    //         ];
    //     }
    //     return $validated;
    // }

}
