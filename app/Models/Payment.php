<?php

namespace App\Models;

use App\Http\Traits\HasUserstamps;
use App\Http\Traits\HasAppendablePagination;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use HasUserstamps;
    use HasAppendablePagination;
    use SoftDeletes;

    protected $table = "p_payments";
    protected $fillable = ["reference", "status", "receiver_transaction_id", "donor_id", "amount", "currency", "notes", "received_at"];
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
    public function receiverTransaction()
    {
        return $this->belongsTo(ReceiverTransaction::class,"receiver_transaction_id");
    }

    public function getDonorNameAttribute()
    {
        return ["name"=>$this->donor->name,"email"=>$this->donor->email];
    }
}
