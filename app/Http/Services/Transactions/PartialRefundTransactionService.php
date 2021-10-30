<?php

namespace App\Http\Services\Transactions;

use App\Enums\BalanceTransactionEnums;
use App\Enums\PaymentStatusEnums;
use App\Models\BalanceTransaction;
use App\Models\Donation;
use App\Models\Payment;
use Exception;

class PartialRefundTransactionService extends RefundTransactionService
{
    protected $paymentTypeAfterTransaction = PaymentStatusEnums::PARTIALLY_REFUNDED;
    protected $balanceTransactionStarterStatus = BalanceTransactionEnums::E_PAYMENT_FULL_REFUND;
    protected $donationsIdsToRefund = [];

    /**
     * @throws Exception
     */
    public function processPartialRefundTransaction(Payment $payment, $note, array $donationsToRefund, $withLose)
    {
        $this->withLose = $withLose;
        $this->donationsIdsToRefund = $donationsToRefund;
        $this->processTransaction($payment, $note);
    }

    public function afterJournalsHandler(BalanceTransaction $balanceTransaction)
    {
        parent::afterJournalsHandler($balanceTransaction); // I might override this again in case of issue

        $this->reInsertPaymentTransactions($balanceTransaction);
    }

    ///

    protected function updatedPaymentAfterTransaction(Payment $payment)
    {
        $donations = Donation::withTrashed()->whereIn("id", $this->donationsIdsToRefund);
        $reversedAmount = $donations->sum("amount");
        $reversedFee = 0;
        if ($this->withLose) {
            $reversedFee = $donations->sum("fee");
        }
        $payment->update([
            "reversed_amount" => $payment->reversed_amount + $reversedAmount,
            "reversed_fee" => $payment->reversed_fee + $reversedFee
        ]);
    }

    protected function deleteSelectedDonations($donations): void
    {
        foreach ($donations as $donation) {
            if (in_array($donation->id, $this->donationsIdsToRefund)) {
                $donation->delete();
            }
        }
    }

    protected function reInsertPaymentTransactions($balanceTransaction)
    {
        $TransactionService = new TransactionService();
        $payment = $balanceTransaction->transactionable;

        //Create new Journal
        $newBalanceTransaction = $payment->balanceTransactions()->create([
            "type" => BalanceTransactionEnums::E_PAYMENT,
            "notes" => $balanceTransaction->notes,
        ]);

        $TransactionService->processEPayment($newBalanceTransaction);
    }
}
