<?php

namespace App\Http\Services\Transactions;

class BaseTransactionService
{
    public  static function  calculateAmountAndDeductionRatio($amount, $deductionRatioRate): array
    {
        $deductedAmount = ($amount * $deductionRatioRate) / 100;

        return ["deductedAmount" => $deductedAmount, "netAmount" => $amount - $deductedAmount];
    }
}
