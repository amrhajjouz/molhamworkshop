<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends BaseModel
{
    use HasFactory;

    protected $fillable = ["name",  "description", "branch_id",  "default_deduction_ratio_id", "currency", "code", "income", "outcome", "balance"];
    protected $guarded = ["code"];

    public static $countryCodeDefault = "TR";
    public static $currencyDefault = "USD";

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];

    public function income($amount)
    {
        $this->income = $this->income + $amount;
        $this->balance = $this->balance + $amount;
        $this->save();
    }

    public function outcome($amount)
    {
        $this->outcome = $this->outcome + $amount;
        $this->balance = $this->balance - $amount;
        $this->save();
    }

    public function defaultDeductionRatio(): belongsTo
    {
        return $this->belongsTo(DeductionRatios::class, "default_deduction_ratio_id");
    }

    public function parentAccountBranch(): BelongsTo
    {
        return $this->BelongsTo(AccountBranch::class, "branch_id")->with("parentAccountBranch");
    }

    public function accountCurrency(): BelongsTo
    {
        return $this->BelongsTo(Currency::class, "currency","code");
    }

    public function getMainNameAccountBranchAttribute(){
        return $this->parentAccountBranch->name;
    }

    public function scopeSearchByName($query, $input)
    {
        if ($input == null)
            return $query;
        return $query->where('name', 'like', "%{$input}%");
    }

    public function scopeSearchByPrefixCodeList($query, $list)
    {
        if($list == null){
            return null;
        }

        return $query->Where(function ($query) use ($list) {
            foreach ($list as $item) {
                $query->orwhere('code', 'like', $item . '%');
            }
        });
    }
}
