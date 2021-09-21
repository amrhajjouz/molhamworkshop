<?php

namespace App\Http\Resources\Target\Cases\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CasesResource extends JsonResource
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
            'target' => [
                'required' => $target->required,
                'beneficiaries_count' => $target->beneficiaries_count,
                'documented' => $target->documented,
                'hidden' => $target->hidden,
                'archived' => $target->archived,
                'code' => $target->code,
                'posted_at' => $target->posted_at,
                'category' => [
                    'name' => $target->category->name,
                ],
            ],
            'place' => [
                'id' => $place->id,
                'name' => $place->fullname[$locale],
            ]
        ];

        return parent::toArray($request);
    }
}
