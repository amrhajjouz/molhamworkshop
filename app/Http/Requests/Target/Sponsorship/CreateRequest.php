<?php

namespace App\Http\Requests\Target\Sponsorship;

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
            'beneficiary_name' => ['required', 'string', 'between:3,100'],
            'beneficiary_birthdate' => ['required', 'date', "before:today"],
            'country_id' => ['required', 'numeric'],
            'sponsored' => ['nullable', 'boolean'],
            'target' => ['array', 'required'],
            'place_id' => ['required', 'numeric'],
            'target.beneficiaries_count' => ['required', 'numeric', 'min:1'],
            'target.required' => ['required', 'numeric', 'min:1'],
            'target.category_id' => ['required'],
            'target.visible' => ['required', 'boolean'],
            'admins_ids' => ['nullable', 'array'], // for adminable model
        ];
    }
}
