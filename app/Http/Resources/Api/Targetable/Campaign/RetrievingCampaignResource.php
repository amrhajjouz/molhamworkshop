<?php

namespace App\Http\Resources\Api\Targetable\Campaign;

use Illuminate\Http\Resources\Json\JsonResource;

class RetrievingCampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */


    public function toArray($request)
    {
        $target = $this->target;
        $faker = \Faker\Factory::create();
        $donor = auth('donor')->user();
        return [
            'id' => $this->id,
            'contents' => $this->transformContentField($target),
            'amounts' =>  generateRandomTargetableAmounts('campaigns', $this->funded), //TEMPORARY
            "liked_by_auth" => $donor ? $donor->likes()->where(['likeable_type' => 'campaign' , 'likeable_id' => $this->id])->exists() : false,
            "funded_by_auth" => $faker->boolean(), //TEMPORARY
            "saved_by_auth" => $faker->boolean(), //TEMPORARY
            "likes_count" => $faker->numberBetween(0, 1000), //TEMPORARY
            "comments_count" => $this->comments()->count() , 
            "shares_count" => $faker->numberBetween(0, 10), //TEMPORARY
            "funded" => $this->funded,
            'published_at' => $target->published_at,
            "urgent" => $this->urgent,
            "funded" => $this->funded,
            "preview_images" => null, //TEMPORARY
        ];
    }

    private function transformContentField($target)
    {
        $data = [];
        foreach (['title', 'description', 'details'] as $field) {
            foreach ($target->$field as $lang => $value) {
                unset($value['proofread']);
                $data[$field][$lang] = $value;
            }
        }
        return $data;
    }
}
