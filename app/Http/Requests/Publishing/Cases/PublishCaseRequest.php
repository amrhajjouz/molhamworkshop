<?php

namespace App\Http\Requests\Publishing\Cases;

use App\Models\Cases;
use App\Models\Place;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PublishCaseRequest extends FormRequest
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
            'id' => ['required' , 'exists:'.Cases::getTableName() . ',id']
        ];
    }
    public function prepareForValidation()
    {
        $target = Cases::findOrFail($this->id)->target;
        if(!isset($target->title['ar']['value']) || !isset($target->description['ar']['value'])  || !isset($target->details['ar']['value'])){
            throw  ValidationException::withMessages(['error'=>'you have to fill contents fields in arabic before publish this case']);
        }
    }

}
