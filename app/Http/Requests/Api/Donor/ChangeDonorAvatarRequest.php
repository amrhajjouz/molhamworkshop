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
        return ['avatar' => ['required', 'image', 'max:3000', 'mimes:peg,bmp,png']];
    }

    public function messages()
    {
        return [
            'avatar.required' => 'avatar_required',
            'avatar.image' => 'invalid_avatar',
            'avatar.mimes' => 'invalid_avatar',
            'email.max' => 'invalid_size',
        ];
    }
}
