<?php

namespace App\Http\Requests\AccountBranch;

use App\Rules\AccountBranchMustBeOfType;
use Illuminate\Foundation\Http\FormRequest;

class CreateAccountBranchRequest extends FormRequest
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
            'name.ar' => ['required', 'string'],
            'name.en' => ['required', 'string'],
            'parent_id' => ['required', new AccountBranchMustBeOfType("title")],
        ];
    }
}
