<?php

namespace App\Http\Requests\Target\Event;


use App\Common\Base\BaseRequest;
use Illuminate\Validation\Rule;

class ReviewUnReviewRequest extends BaseRequest
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
        $rules = [
        ];
        
        return $rules;
    }
}
