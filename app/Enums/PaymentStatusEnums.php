<?php
namespace App\Enums;

abstract class PaymentStatusEnums
{
    const PROCESSING = "processing";
    const PAID = "paid";
    const REFUNDED = "refunded";
    const PARTIALLY_REFUNDED = "partially_refunded";
    const FAILED = "failed";
    const REVERSED = "reversed";
}
