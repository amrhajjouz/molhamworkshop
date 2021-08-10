<?php

namespace App\Http\Requests\Api\Donor;

use Illuminate\Foundation\Http\FormRequest;
use App\Common\ApiFormRequest;
use Illuminate\Http\JsonResponse;

class AuthenticateDonorRequest extends ApiFormRequest
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
            'email' => 'required|email|max:255',
            'password' => 'required',
        ];
    }

    public function messages(){

        return [
            'email.*' => 'bad_credintials' ,
            'password.*' => 'bad_credintials' ,
        ];
        
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return handleResponse(['error' =>  $validator->errors()->first()]);
    }

}
