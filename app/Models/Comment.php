<?php

namespace App\Models;


class Comment extends BaseModel
{
    protected $table = 'comments';
    protected $casts = ['created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s'];
    protected $guarded = [];

    public function commenter()
    {
        return $this->morphTo();
    }
   
    public function commentable()
    {
        return $this->morphTo();
    }

}
