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
        $this->resource->getCollection()->transform(function ($scholraship) use($faker) {
            return [
                'id' => $scholraship->id,
                'contents' => $this->transformContentField($scholraship->target) ,
                'amounts' =>  generateRandomTargetableAmounts('scholarships', $scholraship->funded), //TEMPORARY
                "liked_by_auth" => $faker->boolean(), //TEMPORARY
                "funded_by_auth" => $faker->boolean(),//TEMPORARY
                "saved_by_auth" => $faker->boolean(),//TEMPORARY
                "likes_count" => $faker->numberBetween(0 , 1000),//TEMPORARY
                "comments_count" => $faker->numberBetween(0 , 200),//TEMPORARY
                "shares_count" => $faker->numberBetween(0 , 10),//TEMPORARY
                "preview_images" => null,//TEMPORARY
                'published_at' => $scholraship->target->published_at,
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
