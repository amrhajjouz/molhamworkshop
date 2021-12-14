<?php

namespace App\Http\Resources\Dashboard\Program\Medical\Cases;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleCaseResource extends JsonResource
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
        $locale = app()->getLocale();
        $place = $this->place;
        return [
            'id' => $this->id,
            'beneficiary_name' => $this->beneficiary_name,
            'serial_number' => $this->serial_number,
            'country_code' => $this->country_code,
            'status' => $this->status,
            'country' => [
                'name' => $this->country->name[$locale],
            ],
            //target
            'required' => $target->required,
            'received' => $target->received,
            'spent' => $target->spent,
            'left' => $target->left,
            'left_to_complete' => $target->left_to_complete,
            'beneficiaries_count' => $target->beneficiaries_count,
            'documented' => $target->documented,
            'is_hidden' => $target->is_hidden,
            'title' => $target->title,
            'description' => $target->description,
            'details' => $target->details,
            'archived' => $target->archived,
            'code' => $target->code,
            'published_at' => $target->published_at,
            'ready_to_publish' => $target->ready_to_publish,
            'category' => [
                'name' => $target->category->name,
            ],
            'place' => [
                'id' => $place->id,
                'name' => $place->fullname[$locale],
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
