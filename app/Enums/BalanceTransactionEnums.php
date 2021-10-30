<?php
namespace App\Enums;

abstract class BalanceTransactionEnums
{
    const MANUAL_PAYMENT = "manual_payment";
    const E_PAYMENT = "e_payment";
    const MANUAL_PAYMENT_REVERSAL = "manual_payment_reversal";
    const E_PAYMENT_PAYMENT_REVERSAL = "e_payment_payment_reversal";
    const E_PAYMENT_FULL_REFUND = "e_payment_full_refund";
    const E_PAYMENT_PARTIAL_REFUND = "e_payment_partial_refund";
    const TRANSFER = "transfer";
    const RELOCATE = "relocate";
}
