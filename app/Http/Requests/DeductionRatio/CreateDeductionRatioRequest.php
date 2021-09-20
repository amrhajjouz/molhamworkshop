<?php

namespace App\Http\Requests\DeductionRatio;

use App\Rules\AccountBranchMustBeOfType;
use App\Rules\RatioSumsMustBeEqual;
use Illuminate\Foundation\Http\FormRequest;

class CreateDeductionRatioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name.ar' => ['required', 'string'],
            'name.en' => ['required', 'string'],
            'description.ar' => ['string', 'nullable'],
            'description.en' => ['string', 'nullable'],
            'ratio' => ['required', "numeric", "min:0", "not_in:0"],
            'targets' => ["required", "array", "min:1"],
            'targets.*.account_id' => ['required', "distinct"],
            'targets.*.ratio' => ["min:0", "not_in:0", "required", new RatioSumsMustBeEqual()],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'targets.*.account_id.distinct' => "The account_id field has a duplicate value.",
            'targets.*.account_id.required' => "All account_id fields are required.",
            'targets.*.account_id.ratio.required' => "All ratio fields are required.",
            'targets.*.account_id.ratio.min' => "All ratio fields must be bigger than 0.",
            'targets.*.account_id.ratio.not_in' => "All ratio fields must be bigger than 0.",
        ];
    }
}
