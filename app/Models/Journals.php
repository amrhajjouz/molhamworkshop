<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journals extends Model
{
    use HasFactory;

    protected $guarded = ["type", "notes"];

    public function journalable()
    {
        return $this->morphTo();
    }

    public function transactions()
    {
        return $this->hasMany(Transactions::class,"journal_id","id");
    }
}
