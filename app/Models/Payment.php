<?php

namespace App\Models;

use App\Http\Traits\HasUserstamps;
use App\Http\Traits\HasAppendablePagination;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ["reference", "donor_id", "notes", "received_at", "currency", "status", "fee", "fx_rate", "method","amount"];

    public function donations()
    {
        return $this->hasMany(Donation::class, "payment_id");
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}
