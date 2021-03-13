<?php

namespace App\Http\Requests\Target\Student;

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
            'name' => ['required' ,'string', 'between:3,100'],
            'country_id' => ['required' ,'numeric'],
            'status' => ['nullable' ,'string'],
            'semesters_count' => ['required' ,'numeric'],
            // 'semesters_funded' => ['required' ,'numeric'],
            // 'semesters_left' => ['required' ,'numeric'],
            'current_semester' => ['required' ,'numeric'],
            'target' => ['nullable'],
        ];
    }


    
    
}