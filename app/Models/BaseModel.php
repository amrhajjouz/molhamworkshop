<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function scopeSearchBy($query, $column, $input)
    {
        if ($input == null)
            return $query;
        return $query->where($column, 'like', "%{$input}%");
    }
}
