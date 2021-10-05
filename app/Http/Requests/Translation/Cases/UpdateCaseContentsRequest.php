<?php

namespace App\Http\Requests\Translation\Cases;

use App\Models\Cases;
use App\Models\Place;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateCaseContentsRequest extends FormRequest
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
            'locale' => ['required' , Rule::in(['ar' , 'en' , 'fr' , 'de' , 'tr' , 'es'])],
            'title' => ['required', 'string', 'between:3,100'],
            'description' => ['required', 'string', 'between:3,1000'],
            'details' => ['required', 'string', 'between:3,1000'],
        ];
    }
    public function validated()
    {
        $locale = $this->validator->validated()['locale'];
        return  [
            'title' => [
                $locale => $this->title , 
            ],
            'description' => [
                $locale => $this->description , 
            ],
            'details' => [
                $locale => $this->details , 
            ],
        ];
    }

}
