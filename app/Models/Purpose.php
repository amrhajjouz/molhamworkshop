<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purpose extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i',
        'received_at' => 'datetime:Y-m-d h:i',
        'amount' => 'float',
        'fee' => 'float',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, "account_id");
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function scopeSearchByName($query, $input)
    {
        if ($input == null)
            return $query;
        return $query->where('name', 'like', "%{$input}%");
    }
}
