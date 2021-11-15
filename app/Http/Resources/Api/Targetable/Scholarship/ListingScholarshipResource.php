<?php

namespace App\Http\Resources\Api\Targetable\Scholarship;

use Illuminate\Http\Resources\Json\JsonResource;

class ListingScholarshipResource extends JsonResource
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
        $this->resource->getCollection()->transform(function ($scholarship) use($faker) {
            return [
                'id' => $scholarship->id,
                'contents' => $this->transformContentField($scholarship->target) ,
                'amounts' =>  generateRandomTargetableAmounts('scholarships', $scholarship->funded), //TEMPORARY
                "liked_by_auth" => authDonor()->likes()->where(['likeable_type' => 'scholarship' , 'likeable_id' => $scholarship->id])->exists(),
                "funded_by_auth" => $faker->boolean(),//TEMPORARY
                "saved_by_auth" => $faker->boolean(),//TEMPORARY
                "likes_count" => $faker->numberBetween(0 , 1000),//TEMPORARY
                "comments_count" => $scholarship->comments()->count() , 
                "shares_count" => $faker->numberBetween(0 , 10),//TEMPORARY
                "preview_images" => null,//TEMPORARY
                'published_at' => $scholarship->target->published_at,
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
