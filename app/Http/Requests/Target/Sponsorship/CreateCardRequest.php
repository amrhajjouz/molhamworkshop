<?php

namespace App\Http\Requests\Target\Sponsorship;


use App\Common\Base\BaseRequest;
use Illuminate\Validation\Rule;

class CreateCardRequest extends BaseRequest
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

        $rules = [
            'name' => ['required', 'string',  'between:2,100'],
            'description' => ['required', 'string',  'between:2,100']
        ];





        return $rules;
    }
}
