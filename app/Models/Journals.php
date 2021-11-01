<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journals extends Model
{
    use HasFactory;

    protected $fillable = ["notes","type","related_to","journalable_type","journalable_id"];

    public function transactions()
    {
        return $this->hasMany(Transaction::class,"journal_id","id");
    }

    public function balanceTransaction()
    {
        return $this->belongsTo(BalanceTransaction::class,"balance_transaction_id");
    }
}
