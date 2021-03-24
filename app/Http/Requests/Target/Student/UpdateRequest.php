<?php

namespace App\Http\Requests\Target\Student;

use App\Common\Base\BaseRequest;
use Illuminate\Validation\Rule;

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
            'id' => ['required', 'exists:students'],
            'name' => ['required', 'string', 'between:3,100'],
            'country_id' => ['required', 'numeric'],
            'status' => ['nullable', 'string'],
            'semesters_count' => ['required', 'numeric'],
            'current_semester' => ['required', 'numeric'],
            'place_id' => ['required', 'numeric'],
            'target' => ['required', 'array'],
            // 'target.beneficiaries_count' => ['required', 'numeric', 'min:1'],
            'target.required' => ['required', 'numeric', 'min:1'],
            'target.visible' => ['required', 'boolean'],
            'target.documented' => ['required', 'boolean'],
            'target.archived' => ['required', 'boolean'],
        ];
    }
}
