<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

class CreateRequest extends FormRequest
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
            'fileable_id' => ['required', 'numeric'],
            'fileable_type' => ['required', 'string'],
            'source' => ['nullable', 'string', Rule::in('googleDrive', 'trello', 'local')],
            'accessToken' => ['nullable', 'string'],
            'attachments' => ['nullable', 'array'],
            'attachments.*.id' => ['required', 'string'],
            'attachments.*.name' => ['required', 'string'],
            'attachments.*.mimeType' => ['required', 'string'],
            'file'=> ['sometimes' , 'file' , ],
        ];
    }
}
