<?php

namespace App\Http\Requests\DeductionRatio;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeductionRatioRequest extends FormRequest
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
        ];
    }
}
