<?php

namespace App\Http\Requests\Faq;

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
        $fields = \App\Models\Faq::get_content_fields();
        
        $rules = [
           'category_id' => ['required'],
            'contents' => ['required', 'array'],
            'contents.question.value' => ['required', 'string'],
            'contents.question.name' => ['required', 'string'],
            'contents.answer.value' => ['required', 'string'],
            'contents.answer.name' => ['required', 'string'],
            
        ];
        // dd($rules , $this->all());
        return $rules;
    }
    
}