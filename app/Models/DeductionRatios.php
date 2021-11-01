<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeductionRatios extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ["name", "description", "ratio", "account_id"];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'ratio' => 'float',
    ];

    public function account(): belongsTo
    {
        return $this->belongsTo(Account::class, "account_id", "id");
    }

    public function scopeSearchByName($query, $input)
    {
        if ($input == null)
            return $query;
        return $query->where('name', 'like', "%{$input}%");
    }
}
