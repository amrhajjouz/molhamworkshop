<?php

namespace App\Http\Requests\Target\Cases;

use App\Models\Place;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CreateCaseRequest extends FormRequest
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
            'country_code' => ['required', 'string', 'exists:countries,code', Rule::in(['SY', 'TR', 'LB', 'JO', 'EG'])],
            'target' => ['required', 'array'],
            'target.beneficiaries_count' => ['required', 'numeric', 'min:1'],
            'target.required' => ['required', 'numeric', 'min:1'],
            'target.hidden' => ['required', 'boolean'],
            'place_id' => ['required', 'exists:places,id'],
        ];
    }

    protected function prepareForValidation()
    {
        $place = Place::find($this->place_id);
        if (!$place || !$place->country_code) throw ValidationException::withMessages(['place_id' => 'invalid place']);
        $this->merge(['country_code' => $place->country_code,]);
    }
}
