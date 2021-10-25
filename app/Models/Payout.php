<?php

namespace App\Models;

use App\Http\Traits\HasAppendablePagination;
use App\Http\Traits\HasUserstamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payout extends Model
{
    use HasFactory;
    use HasUserstamps;
    use HasAppendablePagination;
    use SoftDeletes;

    protected $table = "p_payouts";
    protected $fillable = ["currency", "amount", "reference", "country_id", "created_at", "receiver_transaction_id", "payment_transaction_id"];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i',
        'updated_at' => 'datetime:Y-m-d h:i',
        'amount' => 'float',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, "payout_voucher_id");
    }

    public function getCountryNameAttribute()
    {
        return $this->country->name;
    }
    public function getPurposeNameAttribute()
    {
        return getTransactionPurposeName($this->voucher->purpose_type);
    }
}
