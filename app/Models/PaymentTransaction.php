<?php

namespace App\Models;

use App\Http\Traits\HasAppendablePagination;
use App\Http\Traits\HasUserstamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTransaction extends Model
{
    use HasFactory;
    use HasUserstamps;
    use HasAppendablePagination;
    use SoftDeletes;

    protected $table = "p_payment_transactions";
    protected $fillable = ["type", "purpose_type", "amount", "notes", "related_to"];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i',
        'amount' => 'float',
    ];

    public function donation()
    {
        return $this->hasone(Donation::class);
    }

    public function transactionRelated()
    {
        return $this->belongsTo(PaymentTransaction::class, "related_to", "id");
    }

    public function scopeGetByPurposeType($query, $purposeType)
    {
        return $query->where("purpose_type", $purposeType);
    }

    public function getDonorNameAttribute()
    {
        if ($this->donation == null) {
            return [];
        }

        return ["name" => $this->donation->donor->name, "email" => $this->donation->donor->email];
    }

    public function getExtraDescriptionAttribute()
    {
        if($this->related_to == null){
            $related_to = null;
        }else{
            $related_to = getTransactionPurposeName($this->transactionRelated->purpose_type);
        }

        if($this->donation == null){
            $paymentMethod = null;
        }else{
            $paymentMethod = getPaymentMethodName($this->donation->payment_method);
        }

        return getPaymentTransactionDescription(
            $this->type,
            $this->amount,
            $related_to,
            $paymentMethod,
        );
    }
}
