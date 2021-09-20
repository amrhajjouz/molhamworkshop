<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeductionRatiosAccount extends Model
{
    use HasFactory;

    protected $fillable = ["ratio", "account_id", "deduction_ratio_id"];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'ratio' => 'float',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, "account_id");
    }

    public function deductionRatio()
    {
        return $this->belongsTo(DeductionRatios::class, "deduction_ratio_id");
    }
}
