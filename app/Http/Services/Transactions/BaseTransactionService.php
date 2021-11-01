<?php

namespace App\Http\Services\Transactions;

use App\Enums\JournalEnums;
use App\Models\BalanceTransaction;
use App\Models\Journals;

class BaseTransactionService
{
    public  static function  calculateAmountAndDeductionRatio($amount, $deductionRatioRate): array
    {
        $deductedAmount = ($amount * $deductionRatioRate) / 100;

        return ["deductedAmount" => $deductedAmount, "netAmount" => $amount - $deductedAmount];
    }

    /** @noinspection PhpIncompatibleReturnTypeInspection */
    public static function createNewJournal(BalanceTransaction $balanceTransaction, string $type) : Journals
    {
        return $balanceTransaction->journals()->create([
            "type" => $type
        ]);
    }
}
