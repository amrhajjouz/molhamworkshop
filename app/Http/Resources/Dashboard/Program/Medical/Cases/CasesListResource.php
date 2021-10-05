<?php

namespace App\Http\Resources\Dashboard\Program\Medical\Cases;

use Illuminate\Http\Resources\Json\JsonResource;

class CasesListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->resource->getCollection()->transform(function ($case) {
            return [
                'id' => $case->id,
                'beneficiary_name' => $case->beneficiary_name,
                'serial_number' => $case->serial_number,
                'country_code' => $case->country_code,
                'status' => $case->status,
                'beneficiaries_count' => $case->beneficiaries_count ,
                'is_hidden' => $case->target->is_hidden ,
                'archived' => $case->target->archived ,
                'documented' => $case->target->documented ,
                'required' => $case->target->required ,
                'published_at' => $case->target->published_at ,
                'publishable' => $case->target->publishable ,
                'title' => $case->target->title ,
                'available_locales'=>$case->target->available_locales
            ];
        });

        
        return  $this->resource;
    }
}
