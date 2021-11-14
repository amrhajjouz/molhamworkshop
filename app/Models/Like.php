<?php

namespace App\Models;


class Like extends BaseModel
{
    protected $table = 'likes';
    protected $casts = ['created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s'];
    protected $guarded = [];

    public function liker()
    {
        return $this->morphTo();
    }
   
    public function likeable()
    {
        return $this->morphTo();
    }

}
