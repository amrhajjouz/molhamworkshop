<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountBranch extends Model
{
    protected $fillable = ["name", "type", "description", "parent_id", "country_code", "code",  "balance"];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];
    const MainTitleCodeId = ["10", "11", "12", "13", "14", "15"];

    public function parentAccountBranch(): BelongsTo
    {
        return $this->BelongsTo(AccountBranch::class, "parent_id")->with("parentAccountBranch");
    }

    public function childAccounts()
    {
        return $this->hasMany(Account::class, "branch_id","id");
    }

    public function childBranchAccounts()
    {
        return $this->hasMany(AccountBranch::class, "parent_id");
    }

    public function scopeSearchByName($query, $input)
    {
        if ($input == null)
            return $query;

        return $query->where('name', 'like', "%{$input}%");
    }

    public function scopeSearchByType($query, $input)
    {
        if ($input == null)
            return $query;

        return $query->where('type', $input);
    }

    public function getIsMainTitleAttribute()
    {
        return isset($this->code) && in_array($this->code, self::MainTitleCodeId);
    }

    public function getIsChildOfMainTitleAttribute()
    {
        if($this->type == "category"){
            return false;
        }

        if($this->type == "title")
            return $this->getIsMainTitleAttribute();

        $details = $this->getParentListDetails();
        $code = $details["title"]["code"];
        return isset($code) && in_array($code, self::MainTitleCodeId);
    }

    private function getParentListDetails(): array
    {
        $category = ["category", "title", "main"];
        $account = $this;
        $details = array();
        $currentCategoryIndex = array_search($account->type, $category);
        while (isset($account) == true) {
            $details[$category[$currentCategoryIndex--]] = ["name" => $account->name, "code" => $account->code];
            $account = $account->parentAccountBranch;
        }
        return $details;
    }

    /*
     *This method will get all the parents details of the current
     */

    public function getParentDetailsAttribute()
    {
        return $this->getParentListDetails();
    }

    /**
     * you are required to use the attached example code for this
     * <code>
     *  with(["childAccounts:id,parent_id"])
     * </code>
     * @return string
     */
    public function getNextExpectedCodeAttribute(): string
    {
       if (isset($this->parentAccountBranch) && isset($this->childBranchAccounts)) {
            $nextExpectedNumber = count($this->childBranchAccounts) + 1;
            $parentAccountBranchCodeId = $this->parentAccountBranch->code;
            return "$parentAccountBranchCodeId-{$this->code}-{$nextExpectedNumber}";
        }
        return '';
    }}
