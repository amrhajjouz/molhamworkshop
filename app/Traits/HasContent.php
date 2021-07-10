<?php

namespace App\Traits;

trait HasContent
{
    /* 
     * Abstract Function
     * @return array of fields contents names for this model 
    */
    abstract public static function get_content_fields();
    /* 
     * retrive any field value from content table 
    */
    public function  get_content($name)
    {
        $content = [];
        $locales = config('general.available_locales');
        foreach ($locales as $l) {$content[$l] = null;}
        $contents = $this->contents()->where('name' , $name)->whereIn('locale', $locales)->get();
        foreach ($contents as $c) $content[$c->locale] = $c->value;
        return $content;
    }

    /* 
     * Relation for this model with Content Model 
    */
    public function contents()
    {
        return $this->morphMany(\App\Models\Content::class, 'contentable')->orderBy('id', 'desc');
    }


    

}
