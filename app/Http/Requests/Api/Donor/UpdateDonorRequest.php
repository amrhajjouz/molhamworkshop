<?php

namespace App\Http\Requests\Donor;

use Illuminate\Foundation\Http\FormRequest;

class   UpdateDonorRequest extends FormRequest
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
        $user = $this->user();

        return [
            'name' => 'required|string|min:3|max:50',
            'country_code' => 'nullable|string|exists:countries,code',
            'phone' => ['nullable', 'unique:donors,phone,' . $user->id, 'regex:/^([0-9\s\-\+\(\)]*)$/', 'starts_with:+,00', 'min:10', 'max:13']
        ];
    }
}
