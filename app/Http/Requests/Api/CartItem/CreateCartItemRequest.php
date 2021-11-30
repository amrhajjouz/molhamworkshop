<?php

namespace App\Http\Requests\Api\CartItem;

use App\Models\Purpose;
use Illuminate\Foundation\Http\FormRequest;

class CreateCartItemRequest extends FormRequest
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
            // 'currency' => ['required', 'string', 'between:1,3'],
            'amount' => ['required', 'numeric' , 'between:1,10000000'],
            'purpose_id' => ['required', 'exists:'.Purpose::getTableName().',id'],
        ];
    }
}
