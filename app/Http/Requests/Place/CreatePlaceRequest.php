<?php

namespace App\Http\Requests\Place;

use App\Models\Place;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Validation\ValidationException;

class CreatePlaceRequest extends FormRequest
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
            'name' => ['required', 'array'],
            'name.ar' => ['required', 'string', 'between:3,30'],
            'name.en' => ['required', 'string', 'between:3,30'],
            'type' => ['required', Rule::in('province', 'city', 'village', 'district')],
            'parent_id' => ['nullable', 'numeric',  new RequiredIf($this->type != 'province'),],
            'country_code' => ['nullable', 'string', new RequiredIf($this->type == 'province'), 'exists:countries,code'],
        ];
    }

    public function prepareForValidation()
    {
        if (is_array($this->parent_id)) $this->merge(['parent_id' => null]);
        $errors = [];

        if (($this->type == "district" || $this->type == 'village') && $this->parent_type == 'city' && Place::findOrFail($this->parent_id)->type !== "city") {
            $errors['parent_id'] = ["invalid parent "];
        }

        if (($this->type == "district" || $this->type == 'village') && $this->parent_type == 'province' && Place::findOrFail($this->parent_id)->type !== "province") {
            $errors['parent_id'] = ["invalid parent "];
        }

        if (sizeof($errors) > 0) {
            throw ValidationException::withMessages($errors);
        }
    }
}
