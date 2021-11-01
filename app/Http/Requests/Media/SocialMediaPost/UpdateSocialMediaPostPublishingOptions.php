<?php

namespace App\Http\Requests\Media\SocialMediaPost;

use App\Models\SocialMediaPost;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSocialMediaPostPublishingOptions extends FormRequest
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
            'id' => ['required', 'exists:' . SocialMediaPost::getTableName() . ',id'],
            'publishing' => ['required', 'array'],
            'publishing.published_on_facebook_at' => ['sometimes', 'boolean'],
            'publishing.published_on_twitter_at' => ['sometimes', 'boolean'],
            'publishing.published_on_youtube_at' => ['sometimes', 'boolean'],
            'publishing.published_on_instagram_at' => ['sometimes', 'boolean'],
            'scheduling' => ['required', 'array'],
            'scheduling.scheduled_on_facebook_at' => ['nullable', 'date_format:Y-m-d H:i:s' , ],
            'scheduling.scheduled_on_twitter_at' => ['nullable', 'date_format:Y-m-d H:i:s' , ],
            'scheduling.scheduled_on_youtube_at' => ['nullable', 'date_format:Y-m-d H:i:s' , ],
            'scheduling.scheduled_on_instagram_at' => ['nullable', 'date_format:Y-m-d H:i:s' , ],
        ];
    }

    protected function prepareForValidation()
    {
        $scheduling = ['scheduled_on_facebook_at' => null , 'scheduled_on_twitter_at' => null , 'scheduled_on_youtube_at' => null , 'scheduled_on_instagram_at' => null , ];
        if($this->scheduled_on_facebook_at != null &&$this->isScheduled['scheduled_on_facebook_at']){
            $scheduling['scheduled_on_facebook_at'] =  date('Y-m-d H:i:s' , strtotime($this->scheduled_on_facebook_at));
        }
        if($this->scheduled_on_twitter_at != null &&$this->isScheduled['scheduled_on_twitter_at'] ){
            $scheduling['scheduled_on_twitter_at'] =  date('Y-m-d H:i:s' , strtotime($this->scheduled_on_twitter_at));
        }
        if($this->scheduled_on_youtube_at != null &&$this->isScheduled['scheduled_on_youtube_at']){
            $scheduling['scheduled_on_youtube_at'] =  date('Y-m-d H:i:s' , strtotime($this->scheduled_on_youtube_at));
        }
        if($this->scheduled_on_instagram_at != null &&$this->isScheduled['scheduled_on_instagram_at']){
            $scheduling['scheduled_on_instagram_at'] =  date('Y-m-d H:i:s' , strtotime($this->scheduled_on_instagram_at));
        }
        $this->merge(['scheduling' => $scheduling]);
    }
}
