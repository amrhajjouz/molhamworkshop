<?php

namespace App\Http\Resources\Api\Targetable\SmallProject;

use Illuminate\Http\Resources\Json\JsonResource;

class ListingSmallProjectResource extends JsonResource
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
        $this->resource->getCollection()->transform(function ($smallProject) use($faker) {
            return [
                'id' => $smallProject->id,
                'contents' => $this->transformContentField($smallProject->target) ,
                'amounts' =>  generateRandomTargetableAmounts('small_projects', $smallProject->funded), //TEMPORARY
                "liked_by_auth" => authDonor()->likes()->where(['likeable_type' => 'small_project' , 'likeable_id' => $smallProject->id])->exists(),
                "funded_by_auth" => $faker->boolean(),//TEMPORARY
                "saved_by_auth" => $faker->boolean(),//TEMPORARY
                "likes_count" => $faker->numberBetween(0 , 1000),//TEMPORARY
                "comments_count" => $smallProject->comments()->count() , 
                "shares_count" => $faker->numberBetween(0 , 10),//TEMPORARY
                'published_at' => $smallProject->target->published_at,
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
