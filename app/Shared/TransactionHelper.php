<?php

namespace App\Shared;

class TransactionHelper
{
    public static function TypeList(): array
    {
        return ["payment", "transfer", "exchange", "payout"];
    }
}
