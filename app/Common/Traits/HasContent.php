<?php

namespace App\Common\Traits;

trait HasContent
{


    /* 
     * retrive any field value from content table 
    */

    public function  get_content($name)
    {
        $content = [];
        $locales = config('general.available_locales');


        foreach ($locales as $l) {
            $content[$l] = null;
        }

        $contents = $this->contents()->where('name' , $name)
        ->whereIn('locale', $locales)
        ->get();

        foreach ($contents as $c) $content[$c->locale] = $c->value;
        return $content;
    }




    /* 
     * Relation for this model with Content Model 
    */
    public function contents()
    {
        return $this->morphMany(\App\Models\Content::class, 'contentable');
    }


}
