<?php

namespace App\Models;

use App\Http\Traits\HasAppendablePagination;
use App\Http\Traits\HasUserstamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    use HasAppendablePagination;
    use HasUserstamps;
    protected $table = "p_payout_vouchers";
    protected $fillable = ["amount", "currency",  "agreement_id", "purpose_id", "purpose_type", "assignee_id", "country_id", "details", "account_id", "spent_at", "delivered_at"];

    protected $casts = [
        'amount' => 'float',
        'created_at' => 'datetime:Y-m-d h:i',
        'updated_at' => 'datetime:Y-m-d h:i',
        'spent_at' => 'datetime:Y-m-d h:i',
        'delivered_at' => 'datetime:Y-m-d h:i',
    ];
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function agreement()
    {
        return $this->belongsTo(Agreement::class,"agreement_id");
    }

    public function assignee()
    {
        return $this->belongsTo(User::class,"assignee_id");
    }
    public function payout()
    {
        return $this->hasone(Payout::class,"payout_voucher_id");
    }

    public function account()
    {
        return $this->belongsTo(User::class,"account_id");
    }

    //todo: this will be changed later to accept multi language
    function getTransactionPurposeNameAttribute()
    {
        return getTransactionPurposeName($this->purpose_type);
    }

    public function getCountryNameAttribute()
    {
        return $this->country->name;
    }

    public function scopeSearchByCurrency($query, $input)
    {
        if ($input == null) {
            return $query;
        }
        return $query->where("currency", "=", $input);
    }

    public function scopeSearchById($query, $input)
    {
        if ($input == null) {
            return $query;
        }
        return $query->whereId($input);
    }

    public function scopeWithoutAgreement($query)
    {
        return $query->whereAgreementId(null);
    }
    public function scopeOnlyCompleted($query)
    {
        return $query->where("delivered_at","!=",null);
    }
}
