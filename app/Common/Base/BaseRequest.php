<?php

namespace App\Common\Base;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BaseRequest extends FormRequest
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
        ];
    }
    

        public function messages()
        {
        return [
            'id.required' => 'حقل المعرف مطلوب',
            'id.exists' => 'العنصر غير موجود',
            'name.required' => 'حقل الاسم مطلوب',
            'name.between' => 'حقل الاسم يجب أن يكون بين 3-100',
            'funded.required' => 'حقل تم تأمينها مطلوب',

        ];
        }

}