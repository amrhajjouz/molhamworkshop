<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeductionRatios extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ["name", "description", "ratio"];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'ratio' => 'float',
    ];

    public function deductionRatiosAccount(): HasMany
    {
        return $this->hasMany(DeductionRatiosAccount::class, "deduction_ratio_id");
    }

    public function scopeSearchByName($query, $input)
    {
        if ($input == null)
            return $query;
        return $query->where('name', 'like', "%{$input}%");
    }
}
