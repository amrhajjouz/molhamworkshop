<?php

namespace App\Http\Services\Transactions;

class TransactionService
{
    public function calculateAmountAndDeductionRatio($amount, $deductionRatioRate): array
    {
        $deductedAmount = ($amount * $deductionRatioRate) / 100;

        return ["deductedAmount" => $deductedAmount, "netAmount" => $amount - $deductedAmount];
    }
}
