<?php

namespace App\Models;

use App\Http\Traits\HasUserstamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    use HasUserstamps;
    protected $table = "r_accounts";
    protected $fillable = ["name", "currency", "initial_balance", "type_id", "left", "income", "outcome"];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i',
        'initial_balance' => 'float',
        'left' => 'float',
        'received' => 'float',
        'sent' => 'float',
    ];

    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function receiver()
    {
        return $this->belongsTo(Receiver::class);
    }

    function scopeFixIncomeOutcome($query)
    {
        $this->income = $this->transactions->where('amount', ">", 0)->sum("amount");
        $this->outcome = $this->transactions->where('amount', "<", 0)->sum("amount");
        $this->left = $this->income + $this->outcome + $this->initial_balance;
        return $this->save();
    }

    public function AddTransaction($transaction)
    {
        $this->transactions()->save($transaction);

        $this->left = $this->left + $transaction->amount;

        if ($transaction->amount > 0) {
            $this->income = $this->income + abs($transaction->amount);
        }

        if ($transaction->amount < 0) {
            $this->outcome = $this->outcome + abs($transaction->amount);
        }

        $this->update([
            "income" => $this->income,
            "outcome" => $this->outcome,
            "left" => $this->left,
        ]);
    }

    public function transactions()
    {
        return $this->hasmany(ReceiverTransaction::class);
    }

    public function scopeSearchByName($query, $input)
    {
        if ($input == null) {
            return $query;
        }
        return $query->whereHas('receiver', function ($q) use ($input) {
            $q->where('name', 'like', "%{$input}%");
        });
    }

    public function scopeSearchByCurrency($query, $input)
    {
        if ($input == null) {
            return $query;
        }
        return $query->where("currency", "=", $input);
    }

    public function scopeOnlyActive($query)
    {
        return $query->where("status", "=", "active");
    }

    public function scopeExceptReceiver($query, $input)
    {
        if ($input == null) {
            return $query;
        }
        return $query->where("receiver_id", "!=", $input);
    }
}
