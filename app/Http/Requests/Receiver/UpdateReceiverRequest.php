<?php

namespace App\Http\Requests\Receiver;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReceiverRequest extends FormRequest
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
            'name' => ['required', 'string', 'between:3,30'],
            'country_id' => ['required', 'exists:countries,id'],
            'status' => ['required']
        ];
    }
}
