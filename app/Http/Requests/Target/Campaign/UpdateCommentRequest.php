<?php

namespace App\Http\Requests\Target\Campaign;


use App\Common\Base\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateCommentRequest extends BaseRequest
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
            'id' => ['required',   'exists:comments'],
            'body' => ['required', 'string',  'between:2,1000'],
        ];





        return $rules;
    }
}
