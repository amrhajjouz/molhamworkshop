<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ["reference", "method", "payment_id", "donor_id", "country_code", "locale", "amount", "currency", "received_at", "fee",  "section_id", "targetable_id", "program_id", "purpose_id", "usd_amount", "deduction_ratio_id"];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i',
        'received_at' => 'datetime:Y-m-d h:i',
        'amount' => 'float',
        'fee' => 'float',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, "country_code", "code");
    }
}
