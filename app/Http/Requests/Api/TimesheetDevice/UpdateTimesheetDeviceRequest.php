<?php

namespace App\Http\Requests\Api\TimesheetDevice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTimesheetDeviceRequest extends FormRequest
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
                              'brand' => ['required', 'string'],
                              'unique_id' => ['required', 'string'],
                              'operating_system' => ['required', 'string'],
                    ];
          }


}
