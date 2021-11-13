<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
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
            'title' => ['string', 'required'],
            'description' => ['string', 'required'],
            'board_id' => ['required', 'numeric', 'exists:boards,id'],
            'reporter_id' => ['required', 'numeric', 'exists:users,id'],
            'asignee_id' => ['required', 'numeric', 'exists:users,id'],
            'start_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'string'],
            'priority' => ['required', 'string'],
            'labels' => ['required'],

        ];
    }
}
