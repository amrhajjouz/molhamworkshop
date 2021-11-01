<?php
namespace App\Enums;

abstract class  JournalEnums
{
    const PAYMENT = "payment";
    const PAYMENT_REVERSAL = "payment_reversal";
    const TRANSFER = "transfer";
    const AUTO_FEE = "auto_fee";
    const AUTO_FEE_REVERSAL = "auto_fee_reversal";
    const FEE_LOSS = "fee_loss";
    const PAYOUT = "payout";
}
