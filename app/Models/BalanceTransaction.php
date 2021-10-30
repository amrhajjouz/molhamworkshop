<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceTransaction extends Model
{
    use HasFactory;
    protected $fillable = ["type","notes"];

    public function journals()
    {
        return $this->hasMany(Journals::class,);
    }

    public function transactionable()
    {
        return $this->morphTo();
    }
}
