<?php

namespace App\Http\Requests\Api\Subscription;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSubscriptionRequest extends FormRequest
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
            'items' => ['required' , 'array' ],
            'items.*.purpose_type' => ['required' , 'string' ],
            'items.*.purpose_id' => ['required' , 'numeric' ],
            'items.*.amount' => ['required' , 'numeric' ],
            'frequency'=>['required' , 'string' , Rule::in(['month' , 'week' , 'day'])],
            'billing_day' => ['required' , "numeric" ,"between:1,28"] ,
            'locale' => ['sometimes', Rule::in(['ar', 'en', 'fr', 'de', 'tr', 'es'])],
        ];
    }
}
