<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RatioSumsMustBeEqual implements Rule
{
    /**
     * Determine if the validation rule passes.
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $ratio = request("ratio");
        $totalRatioSum = collect(request("targets"))->sum('ratio');
        return $ratio == $totalRatioSum;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The target ratio must be equal to the main deduction ratio';
    }
}
