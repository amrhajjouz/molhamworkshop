<?php

namespace App\Common\Traits;

trait HasNote
{


    /* 
     * Relation for this model with Note Model 
    */

    public function notes()
    {
        return $this->morphMany('App\Models\Note', 'noteable');
    }

    public function listing_notes()
    {
        $response = [];
        foreach ($this->notes  as $note) {
            $note->creator;
            $note->reviews = $note->transform_reviews();
            $response[] = $note;
        }

        return $response;
    }


    

}
