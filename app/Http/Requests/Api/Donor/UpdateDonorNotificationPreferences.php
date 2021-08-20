<?php

namespace App\Http\Requests\Api\Donor;

use App\Models\NotificationPreference;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDonorNotificationPreferences extends FormRequest
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
            "preferences" => ['required', 'array'],
            "preferences.*" => [Rule::in(['newsletter', 'subscriptions_2_days_reminder', "subscriptions_1_week_reminder", 'purposes_updates', 'shared_links'])]
        ];
    }

    public function messages()
    {
        return [
            'preferences.required' => 'preferences_required',
            'preferences.array' => 'preferences_must_be_array',
            'preferences.*.*' => 'invalid_preferences_type',
        ];
    }
}
