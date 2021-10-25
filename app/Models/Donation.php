<?php

namespace App\Models;

use App\Http\Traits\HasUserstamps;
use App\Http\Traits\HasAppendablePagination;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory  ;
    use HasUserstamps;
    use HasAppendablePagination;
    use SoftDeletes;

    protected $table = "p_donations";

    protected $fillable = ["reference", "payment_method", "payment_id", "payment_transaction_id", "donor_id", "country_id", "locale", "amount", "currency", "received_at", "fee"];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i',
        'received_at' => 'datetime:Y-m-d h:i',
        'amount' => 'float',
        'fee' => 'float',
    ];

    public function donor(){
        return $this->belongsTo(Donor::class);
    }
    public function transaction(){
        return $this->belongsTo(PaymentTransaction::class,"payment_transaction_id");
    }

    public function payment(){
        return $this->belongsTo(Payment::class);
    }

    public function country(){
        return $this->belongsTo(Country::class,"country_id");
    }

    public function getDonorNameAttribute()
    {
             return ["name"=>$this->donor->name,"email"=>$this->donor->email];
    }

    public function getCountryNameAttribute()
    {
        return $this->country->name;
    }
}
