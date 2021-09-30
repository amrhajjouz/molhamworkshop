<?php

namespace App\Models;

use App\Http\Traits\HasAppendablePagination;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use HasAppendablePagination;

    protected $fillable = ["reference", "donor_id", "notes", "received_at", "currency", "status", "fee", "fx_rate", "method", "amount"];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i',
        'received_at' => 'datetime:Y-m-d h:i',
        'amount' => 'float',
        'fee' => 'float',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class, "payment_id");
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function getDonorNameAttribute()
    {
        return [
            "name" => $this->donor->name,
            "email" => $this->donor->email
        ];
    }
}
