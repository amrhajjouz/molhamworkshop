<?php

namespace App\Http\Requests\Api\Passcode;

use Illuminate\Foundation\Http\FormRequest;

class Check extends FormRequest
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
                              'lat' => 'required',
                              'lng' => 'required',
                              'distance' => 'required',
                              'check_type' => 'required',
                    ];
          }

          public function messages()
          {
                    return [
                              'passcode.required' => 'invalid_passcode',
                              'unique_id.required' => 'invalid_unique_id',
                              'brand.required' => 'invalid_brand',
                              'os.required' => 'invalid_os',
                              'lat.required' => 'invalid_lat',
                              'lng.required' => 'invalid_lng',
                              'distance.required' => 'invalid_distance',
                              'check_type.required' => 'invalid_check_type',
                    ];
          }
}
