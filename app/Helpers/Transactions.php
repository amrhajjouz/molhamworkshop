<?php

function getReceivedTransactionDescription($type, $amount, $receiverName, $accountName): string
{
    switch (true) {
        case $type == "transfer" && $amount > 0:
            $description = "إستقبال دفعة من ";
            break;
        case $type == "transfer" && $amount < 0:
            $description = "إرسال دفعة إلى ";
            break;
        case $type == "exchange" && $amount > 0:
            $description = "تصريف دفعة من";
            break;
        case $type == "exchange" && $amount < 0:
            $description = "تصريف دفعة إلى";
            break;
        case $type == "payment" && $amount > 0:
            $description = "إستقبال تبرع بواسطة ";
            break;
        case $type == "payout":
            $description = "صرف دفعة بواسطة ";
            break;
        default:
            return "Unknown status. check it with your admin";
    }
    return "$description $receiverName ($accountName)";
}

function getPaymentTransactionDescription($type, $amount, $relatedTo, $paymentMethod): string
{
    switch (true) {
        case $type == "donation" && $amount > 0:
            return "  إستقبال تبرع $paymentMethod";
        case $type == "transfer" && $amount < 0:
            return " نقل دفعة إلى $relatedTo";
        case $type == "transfer" && $amount > 0:
            return " استقبال دفعة من $relatedTo";
        case $type == "payout" && $amount > 0:
            return " صرف دفعة من$relatedTo";
        case $type == "fee" && $amount < 0:
            return "خصم رسوم دفع الكتروني";
        case $type == "fee" && $amount > 0:
            return " استقبال رسوم دفع الكتروني من  $relatedTo ";
        default:
            return "Unknown status. check it with your admin";
    }
}

//todo: this will be changed later to accept multi language
function getTransactionPurposeName($type): string
{
    switch ($type) {
        case "administrative_support":
            return "الدعم الإداري";
        case "general_fund":
            return "الصندوق العام ";
        default:
            return $type;
    }
}

//todo: this will be changed later to accept multi language
function getPaymentMethodName($type): string
{
    switch ($type) {
        case "cash":
            return "كاش";
        default:
            return $type;
    }
}
