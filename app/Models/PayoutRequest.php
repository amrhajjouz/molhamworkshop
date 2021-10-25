<?php

namespace App\Models;

use App\Http\Traits\HasAppendablePagination;
use App\Http\Traits\HasUserstamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutRequest extends Model
{
    use HasFactory;
    use HasUserstamps;
    use HasAppendablePagination;

    protected $table = "p_payout_requests";
    protected $fillable = ["amount", "currency", "purpose_id", "purpose_type", "assignee_id", "country_id", "details", "status", "next_review_id", "rejected_at", "rejected_by"];
    protected $casts = [
        'amount' => 'float',
        'created_at' => 'datetime:Y-m-d h:i',
        'updated_at' => 'datetime:Y-m-d h:i',
        'canceled_at' => 'datetime:Y-m-d h:i',
    ];

    public function payoutRequestReviews()
    {
        return $this->hasmany(PayoutRequestReviews::class, "request_id");
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function voucher()
    {
        return $this->hasone(Voucher::class, "payout_request_id");
    }

    public function nextPaymentRequestReview()
    {
        return $this->belongsTo(PayoutRequestReviews::class, "next_review_id");
    }

    public function getHasVoucherAttribute()
    {
        return $this->voucher != null;
    }

    public function getNextReviewNameAttribute()
    {
        return $this->nextPaymentRequestReview->required_role;
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

    public function scopeApproved($query)
    {
        return $query->whereStatus("approved");
    }
}
