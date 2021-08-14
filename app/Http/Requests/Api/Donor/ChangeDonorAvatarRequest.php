<?php

namespace App\Http\Requests\Api\Donor;

use Illuminate\Foundation\Http\FormRequest;

class ChangeDonorAvatarRequest extends FormRequest
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
    public function rules()
    {
        return ['avatar' => ['required', 'image', 'max:3000']];
    }

    public function messages()
    {
        return [
            'avatar.required' => 'image_invalid',
            'avatar.image' => 'image_invalid',
            'avatar.max' => 'invalid_image_size',
        ];
    }
}
