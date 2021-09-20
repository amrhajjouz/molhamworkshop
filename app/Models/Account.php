<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends BaseModel
{
    use HasFactory;

    protected $fillable = ["name",  "description", "branch_id",  "default_deduction_ratio_id", "currency", "code", "income", "outcome", "balance"];

    public static $countryCodeDefault = "TR";
    public static $currencyDefault = "USD";

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];

    public function parentAccountBranch(): BelongsTo
    {
        return $this->BelongsTo(AccountBranch::class, "branch_id")->with("parentAccountBranch");
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
}
