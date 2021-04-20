<?php

namespace App\Http\Requests\Shortcut;

use Illuminate\Validation\Rule;
use App\Common\Base\BaseRequest;
use App\Models\Country;
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
        
        $locales = config('general.available_locales');
        $fields = \App\Models\Shortcut::get_content_fields();


        /* 
        * delete key word from rules because it has many records  
        */
        // $fields = array_filter($fields, function ($e) {
        //     return ($e !== 'keyword');
        // });

        // foreach ($fields  as $key => $field) {
        //     foreach ($locales  as $locale) {
        //         if(is_array($field)){
        //             $rules['contents.' .  $key]  = ['array'];
        //             $rules['contents.' .  $key . '.' . $locale]  = ['nullable'];

        //         }else{
        //             $rules['contents.' .  $field]  = ['array'];
        //             $rules['contents.' .  $field . '.' . $locale]  = ['nullable'];

        //         }
        //     }
        // }

        $rules = [

            'path' => ['required' , 'string'],
            'contents' => ['required' , 'array'],
            'contents.title' => ['required' , 'array'],
            'contents.description' => ['required' , 'array'],
            'contents.title.value' => ['required' , 'string'],
            'contents.description.value' => ['required' , 'string'],
        ];
        // $rules['path'] =['required'];
        // dd($this->all() , $rules);
        return $rules;
    }
    
}