<?php

namespace App\Http\Requests\NotificationTemplate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationTemplateRequest extends FormRequest
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
            'id' => ['required', 'exists:notifications_templates'],
            'name' => ['required', 'string', 'between:3,50', 'unique:notifications_templates,name,' . $this->id],
            'body' => ['required', 'array'],
            'body.en' => ['required', 'string'],
            'body.ar' => ['required', 'string'],
            'path' => ['nullable', 'string'],
        ];
    }
}
