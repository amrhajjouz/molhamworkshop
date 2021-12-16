<?php

namespace App\Http\Resources\Api\Targetable\Cases;

use Illuminate\Http\Resources\Json\JsonResource;

class ListingCaseResource extends JsonResource
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
        // dd($donor->savedItems);
        $this->resource->getCollection()->transform(function ($case) use($faker , $donor) {
            return [
                'id' => $case->id,
                'published_at' => $case->target->published_at,
                'purpose_id' => $case->target->purpose_id,
                'amounts' =>  generateRandomTargetableAmounts('cases', $case->funded), //TEMPORARY
                'contents' => $this->transformContentField($case->target) ,
                "liked_by_auth" => $donor ? $donor->likes()->where(['likeable_type' => 'case' , 'likeable_id' => $case->id])->exists() : false,
                "funded_by_auth" => $faker->boolean(),//TEMPORARY
                "saved_by_auth" => $donor ? $donor->savedItems()->where(['saveable_type' => 'case' , 'saveable_id' => $case->id])->exists() : false,
                "likes_count" => $faker->numberBetween(0 , 1000),//TEMPORARY
                "comments_count" => $case->comments()->count() , 
                "shares_count" => $faker->numberBetween(0 , 10),//TEMPORARY
                "preview_images" => null,//TEMPORARY
                "funded" => $case->funded,
                "urgent" => $case->urgent
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
