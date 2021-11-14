<?php

namespace App\Http\Resources\Api\Targetable\Scholarship;

use Illuminate\Http\Resources\Json\JsonResource;

class RetrievingScholarshipResource extends JsonResource
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
        return [
            'id' => $this->id,
            'contents' => $this->transformContentField($target),
            'amounts' =>  generateRandomTargetableAmounts('scholarships', $this->funded), //TEMPORARY
            "liked_by_auth" => authDonor()->likes()->where(['likeable_type' => 'scholarship' , 'likeable_id' => $this->id])->exists(),
            "funded_by_auth" => $faker->boolean(), //TEMPORARY
            "saved_by_auth" => $faker->boolean(), //TEMPORARY
            "likes_count" => $faker->numberBetween(0, 1000), //TEMPORARY
            "comments_count" => $faker->numberBetween(0, 200), //TEMPORARY
            "shares_count" => $faker->numberBetween(0, 10), //TEMPORARY
            'published_at' => $target->published_at,
            "preview_images" => null, //TEMPORARY
            "funded" => $faker->boolean(), //TEMPORARY
            "sponsored" => $faker->boolean(), //TEMPORARY
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
