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
            'beneficiary_name.required' => 'حقل اسم المستفيد',
            'beneficiary_name.between' => 'حقل اسم المستفيد يجب أن يكون بين 3-100',
            'beneficiary_birthdate.required' => 'حقل تاريخ ميلاد المستفيد مطلوب',
            'beneficiary_birthdate.before' => 'حقل تاريخ ميلاد المستفيد يجب أن يكون أصغر من اليوم    ',
            'sponsored.required' => 'حقل تم كفالتها مطلوب',
            'current_semester.required' => 'حقل الفصل الحالي مطلوب',
            'current_semester.numeric' => 'حقل الفصل الحالي يجب أن يكون رقم',
            // 'semesters_left.required' => 'حقل الفصل الحالي مطلوب',
            // 'semesters_left.numeric' => 'حقل الفصل الحالي يجب أن يكون رقم',

        ];
        }

}