<?php

namespace App\Http\Requests\Leave;

use Illuminate\Foundation\Http\FormRequest;

class CreateLeaveRequest extends FormRequest
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
            'leave_type_id' => ['required', 'numeric', 'exists:leave_types,id'],
            'leave_start_date' => ['required', 'date'],
            'leave_end_date' => ['required', 'date', 'after:leave_start_date'],
            'details' => ['string', 'nullable', 'sometimes'],
            'reason' => ['string', 'nullable', 'sometimes'],
        ];
    }
}
