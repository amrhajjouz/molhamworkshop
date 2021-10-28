<?php

namespace App\Http\Requests\Api\Passcode;

use Illuminate\Foundation\Http\FormRequest;

class VerifyPasscode extends FormRequest
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
                              'passcode' => 'required',
                              'unique_id' => 'required',
                              'brand' => 'required',
                              'os' => 'required',
                    ];
          }

          public function messages()
          {
                    return [
                              'passcode.required' => 'invalid_passcode',
                              'unique_id.required' => 'invalid_unique_id',
                              'brand.required' => 'invalid_brand',
                              'os.required' => 'invalid_os',
                    ];
          }
}
