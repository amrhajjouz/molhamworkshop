<?php

namespace App\Common\Traits;

trait HasCard
{

    /* 
     * Relation for this model with Card Model 
    */


    public function cards()
    {
        return $this->morphMany('App\Models\Card', 'cardable');
    }


    public function listing_cards()
    {
        $response = [];
        
        foreach ($this->cards  as $card) {
            $card->creator;
            $card->updator;
            $response[] = $card;
        }

        return $response;
    }


    

}
