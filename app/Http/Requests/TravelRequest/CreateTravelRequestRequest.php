<?php

namespace App\Http\Requests\TravelRequest;

use Illuminate\Foundation\Http\FormRequest;

class CreateTravelRequestRequest extends FormRequest
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
            'start_date' => ['required' ,'date'],
            'end_date' => ['required' ,'date', 'after:start_date'],
            'travel_destination' => ['required'],
            'means_of_travel' => ['required'],
            'residence' => ['required'],
        ];
    }
}
