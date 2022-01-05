<?php

namespace App\Http\Resources\Api\Targetable\Event;

use Illuminate\Http\Resources\Json\JsonResource;

class ListingEventResource extends JsonResource
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
        $this->resource->getCollection()->transform(function ($event) use($faker , $donor) {
            return [
                'id' => $event->id,
                'contents' => $this->transformContentField($event->target) ,
                'amounts' =>  getTargetableAmount($event), 
                "likes_count" => $event->likes()->count(),
                "liked_by_auth" => $donor ? $donor->likes()->where(['likeable_type' => 'event' , 'likeable_id' => $event->id])->exists() : false,
                "funded_by_auth" => $faker->boolean(),//TEMPORARY
                "saved_by_auth" => $donor ? $donor->savedItems()->where(['saveable_type' => 'event' , 'saveable_id' => $event->id])->exists() : false,
                "comments_count" => $event->comments()->count() , 
                "shares_count" => $faker->numberBetween(0 , 10),//TEMPORARY
                'published_at' => $event->target->published_at,
                'purpose_id' => $event->target->purpose_id,
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
