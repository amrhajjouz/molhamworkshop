<?php

namespace App\Http\Resources\Api\Targetable\Project;

use Illuminate\Http\Resources\Json\JsonResource;

class ListingProjectResource extends JsonResource
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
        $this->resource->getCollection()->transform(function ($project) use($faker , $donor) {
            return [
                'id' => $project->id,
                'contents' => $this->transformContentField($project->target) ,
                'amounts' =>  getTargetableAmount($project), 
                "likes_count" => $project->likes()->count(),
                "liked_by_auth" => $donor ? $donor->likes()->where(['likeable_type' => 'project' , 'likeable_id' => $project->id])->exists() : false,
                "funded_by_auth" => $faker->boolean(),//TEMPORARY
                "saved_by_auth" => $donor ? $donor->savedItems()->where(['saveable_type' => 'project' , 'saveable_id' => $project->id])->exists() : false,
                "comments_count" => $project->comments()->count() , 
                "shares_count" => $faker->numberBetween(0 , 10),//TEMPORARY
                'published_at' => $project->target->published_at,
                'purpose_id' => $project->target->purpose_id,
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
