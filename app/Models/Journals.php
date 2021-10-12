<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journals extends Model
{
    use HasFactory;

    protected $fillable = ["notes"];
    protected $guarded = ["type"];

    public function journalable()
    {
        return $this->morphTo();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class,"journal_id","id");
    }
}
