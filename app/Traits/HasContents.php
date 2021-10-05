<?php

namespace App\Traits;


trait HasContents
{
  
    public function contents()
    {
        return $this->morphMany(\App\Models\Content::class, 'contentable')->orderBy('id', 'desc');
    }
}
