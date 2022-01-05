<?php

namespace App\Http\Resources\Api\Targetable\Sponsorship;

use Illuminate\Http\Resources\Json\JsonResource;

class ListingSponsorshipResource extends JsonResource
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
        $this->resource->getCollection()->transform(function ($sponsorship) use($faker , $donor) {
            return [
                'id' => $sponsorship->id,
                'contents' => $this->transformContentField($sponsorship->target) ,
                'amounts' =>  getTargetableAmount($sponsorship), 
                "likes_count" => $sponsorship->likes()->count(),
                "liked_by_auth" => $donor ? $donor->likes()->where(['likeable_type' => 'sponsorship' , 'likeable_id' => $sponsorship->id])->exists() : false,
                "funded_by_auth" => $faker->boolean(),//TEMPORARY
                "saved_by_auth" => $donor ? $donor->savedItems()->where(['saveable_type' => 'sponsorship' , 'saveable_id' => $sponsorship->id])->exists() : false,
                "comments_count" => $sponsorship->comments()->count() , 
                "shares_count" => $faker->numberBetween(0 , 10),//TEMPORARY
                "preview_images" => null,//TEMPORARY
                'published_at' => $sponsorship->target->published_at,
                'purpose_id' => $sponsorship->target->purpose_id,
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
