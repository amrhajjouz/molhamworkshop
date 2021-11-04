<?php

namespace App\Http\Requests\Media\SocialMediaPost;

use Illuminate\Foundation\Http\FormRequest;

class CreateSocialMediaPostImageRequest extends FormRequest
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
    public function rules()
    {
        return [
            'images' => ['required', 'array'] ,
            'images.*' => ['required', 'image', 'max:3000']
        ];
    }

    protected function prepareForValidation()
    {
        $images = [];
        if(isset($this->images) && is_array($this->images)){
            foreach ($this->images as $val) {
                if(is_file($val)){
                    $images[] = $val;
                }
            }
        }
        $this->merge(['images' => $images]);
    }
}
