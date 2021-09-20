<?php

namespace App\Rules;

use App\Models\Account;
use App\Models\AccountBranch;
use Illuminate\Contracts\Validation\Rule;

class AccountBranchMustBeOfType implements Rule
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return AccountBranch::where('id', $value)->where("type", $this->type)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The selected account must be from {$this->type} category.";
    }
}
