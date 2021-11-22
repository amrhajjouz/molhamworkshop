<?php

namespace App\Http\Resources\Api\Targetable\Campaign;

use Illuminate\Http\Resources\Json\JsonResource;

class ListingCampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $faker = \Faker\Factory::create();    
        $donor = auth('donor')->user();
        $this->resource->getCollection()->transform(function ($campaign) use($faker , $donor) {
            return [
                'id' => $campaign->id,
                'contents' => $this->transformContentField($campaign->target) ,
                'amounts' =>  generateRandomTargetableAmounts('campaigns', $campaign->funded), //TEMPORARY
                "liked_by_auth" => $donor ? $donor->likes()->where(['likeable_type' => 'campaign' , 'likeable_id' => $campaign->id])->exists() : false,
                "funded_by_auth" => $faker->boolean(),//TEMPORARY
                "saved_by_auth" => $faker->boolean(),//TEMPORARY
                "likes_count" => $faker->numberBetween(0 , 1000),//TEMPORARY
                "comments_count" => $campaign->comments()->count() , 
                "shares_count" => $faker->numberBetween(0 , 10),//TEMPORARY
                'published_at' => $campaign->target->published_at,
                "preview_images" => null,//TEMPORARY
            ];
        });
        return  $this->resource;
    }

    private function transformContentField($target)
    {   
        $data = [];
        foreach (['title' , 'description' , 'details'] as $field) {
            foreach ($target->$field as $lang => $value) {
                unset($value['proofread']);
                $data[$field][$lang] = $value;
            }
        }

        return $data;
    }
}
