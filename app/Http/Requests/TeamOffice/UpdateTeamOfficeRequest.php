<?php

namespace App\Http\Requests\TeamOffice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamOfficeRequest extends FormRequest
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
            'id' => ['required', 'exists:team_offices'],
            'name' => ['string', 'between:3,20'],
            'type' => ['required'],
            'address' => ['required'],
            'office_manager' => ['required'],
            'place_id' => ['required'],
        ];
    }
}
