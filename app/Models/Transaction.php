<?php

namespace App\Models;

use App\Http\Traits\HasAppendablePagination;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    use HasAppendablePagination;

    protected $fillable = ["amount", "currency", "fx_rate", "method", "account_id", "section_id", "program_id", "related_to"];

    public function getProgramNameAttribute()
    {
        if ($this->program_id != null) {
            return $this->program->name[app()->getLocale()];
        }

        return "--";
    }

    public function getSectionNameAttribute()
    {
        if ($this->section_id != null) {
            return $this->section->name[app()->getLocale()];
        }

        return "--";
    }

    public function getUsdAmountAttribute()
    {
        $amount = $this->amount / $this->fx_rate;

        return "$" . number_format((float)$amount, 2, '.', '');
    }

    public function getJournalTypeAttribute()
    {
       switch ($this->journal->journalable_type ) {
           case "App\Models\Payment":
               return "Payment";
           default:
               return "--";
       }
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function Journal(): BelongsTo
    {
        return $this->belongsTo(Journals::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
