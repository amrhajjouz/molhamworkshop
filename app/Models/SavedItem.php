<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedItem extends Model
{
    protected $table = 'saved_items';
    protected $casts = ['created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s'];
    protected $guarded = [];

    public function saveable()
    {
        return $this->morphTo();
    }
}
