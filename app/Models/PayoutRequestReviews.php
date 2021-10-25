<?php

namespace App\Models;

use App\Http\Traits\HasAppendablePagination;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutRequestReviews extends Model
{
    use HasFactory;
    use HasAppendablePagination;

    protected $table = "p_payout_request_reviews";
    protected $fillable = ["required_role", "reviewed_by", "notes", "priority", "status"];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i',
        'updated_at' => 'datetime:Y-m-d h:i',
    ];

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, "reviewed_by");
    }

    public function payoutRequest()
    {
        return $this->belongsTo(PayoutRequest::class, "request_id");
    }

    public function getReviewedByNameAttribute()
    {
        if ($this->reviewed_by != null) {
            return $this->reviewedBy->name;
        }
        return null;
    }

    public function getIsApprovableAttribute()
    {
        // just make sure to combine has role with the priority role
        return auth()->user()->hasRole($this->required_role) && $this->status == "pending" && $this->payoutRequest->status == "pending";
    }

    public function getUpdatedAtAttribute()
    {
        if ($this->status != "pending") {
            return $this->attributes["updated_at"];
        }
        return null;
    }

    public function scopePreviousRecords($query, $id)
    {
        return $query->where('id', '<', $id);
    }

    public function scopeLast($query)
    {
        return $query->orderBy('id', 'desc')->first();
    }
}
