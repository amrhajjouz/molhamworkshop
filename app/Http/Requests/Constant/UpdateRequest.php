<?php

namespace App\Http\Requests\Constant;

use App\Common\Base\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;


class UpdateRequest extends BaseRequest
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
            'id' => ['required', 'exists:constants'],
            'plaintext' => ['required', 'boolean'],
            'content' => ['array', 'required'],
            'content.name' => ['string', 'required'],
            'content.value' => ['string', 'required'],
        ];
    }
}
