<?php

namespace App\Models;

use App\Http\Traits\HasAppendablePagination;
use App\Http\Traits\HasUserstamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;
    use HasUserstamps;
    use HasAppendablePagination;

    protected $table = "p_agreements";
    protected $fillable = ["title", "amount", "currency", "admin_costs_percentage", "details", "status", "starting_date", "ending_date", "canceled_by"];
    protected $casts = [
        'starting_date' => 'datetime:Y-m-d h:i',
        'ending_date' => 'datetime:Y-m-d h:i',
        'amount' => 'float',
        'admin_costs_percentage' => 'float',
    ];

    protected $dates = [
        'starting_date',
        'ending_date',
    ];

    public function vouchers()
    {
        return $this->hasMany(Voucher::class, "agreement_id");
    }

    public function getVouchersTotalAmountAttribute()
    {
       $vouchersAmounts =$this->vouchers->sum("amount");
       $adminCostPercentage = $vouchersAmounts * $this->admin_costs_percentage / 100;

       return $vouchersAmounts + $adminCostPercentage;
    }

    public function getVouchersNumberAttribute()
    {
       return $this->vouchers->count();
    }
}
