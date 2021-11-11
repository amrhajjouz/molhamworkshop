<?php

namespace App\Http\Resources\Api\Targetable\Fundraiser;

use Illuminate\Http\Resources\Json\JsonResource;

class ListingFundraiserResource extends JsonResource
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
        $this->resource->getCollection()->transform(function ($campaign) use($faker) {
            return [
                'id' => $campaign->id,
                'contents' => $this->transformContentField($campaign->target) ,
                'amounts' =>  generateRandomTargetableAmounts('fundraisers', $campaign->funded), //TEMPORARY
                "liked_by_auth" => $faker->boolean(), //TEMPORARY
                "funded_by_auth" => $faker->boolean(),//TEMPORARY
                "saved_by_auth" => $faker->boolean(),//TEMPORARY
                "likes_count" => $faker->numberBetween(0 , 1000),//TEMPORARY
                "comments_count" => $faker->numberBetween(0 , 200),//TEMPORARY
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
