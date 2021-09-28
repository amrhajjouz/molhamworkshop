<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purpose extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i',
        'received_at' => 'datetime:Y-m-d h:i',
        'amount' => 'float',
        'fee' => 'float',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, "account_id");
    }

    public function scopeSearchByName($query, $input)
    {
        if ($input == null)
            return $query;
        return $query->where('name', 'like', "%{$input}%");
    }
}
