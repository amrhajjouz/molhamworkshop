<?php

namespace App\Models;

use App\Http\Traits\HasAppendablePagination;
use App\Http\Traits\HasUserstamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiverTransaction extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasAppendablePagination;
    use HasUserstamps;

    protected $table = "r_transactions";
    protected $fillable = ["type", "currency", "amount", "usd_rate", "notes", "related_to", "account_id"];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'amount' => 'float',
        'usd_rate' => 'float'
    ];

    public function accountType()
    {
        return $this->belongsTo(AccountType::class, "type_id");
    }

    public function transactionRelated()
    {
        return $this->belongsTo(ReceiverTransaction::class, "related_to", "id");
    }

    public function account()
    {
        return $this->belongsTo(Account::class, "account_id");
    }

    public function payment()
    {
        return $this->hasone(Payment::class);
    }

    public function scopeGetByReceiverId($query, $receiverId)
    {
        return $query->whereHas('account', function ($query) use ($receiverId) {
            $query->where('receiver_id', $receiverId);
        });
    }

    public function getExtraDescriptionAttribute()
    {
        $donor_name = null;

        if ($this->type == "transfer" || $this->type == "exchange") {
            $accountDetails = $this->transactionRelated->account;
        } elseif ($this->type == "payment"|| $this->type == "payout") {
            $accountDetails = $this->account;
        }

        return getReceivedTransactionDescription($this->type,
            $this->amount,
            $accountDetails->receiver->name
            , $accountDetails->name);
    }
}
