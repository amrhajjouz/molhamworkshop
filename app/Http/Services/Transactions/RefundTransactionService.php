<?php

namespace App\Http\Services\Transactions;

use App\Enums\BalanceTransactionEnums;
use App\Enums\JournalEnums;
use App\Enums\PaymentStatusEnums;
use App\Models\Account;
use App\Models\BalanceTransaction;
use App\Models\Payment;
use Exception;

class RefundTransactionService extends ReversalTransactionService
{
    protected $paymentTypeAfterTransaction = PaymentStatusEnums::REFUNDED;
    protected $journalStatusAfterTransaction = JournalEnums::PAYMENT_REVERSAL;
    protected $balanceTransactionStarterStatus = BalanceTransactionEnums::E_PAYMENT_FULL_REFUND;
    protected $withLose = false;

    /**
     * @throws Exception
     */
    public function processRefundTransaction(Payment $payment, $note, $allowLose)
    {
        $this->withLose = $allowLose;
        $this->processTransaction($payment, $note);
    }

    /**
     * @param BalanceTransaction $balanceTransaction
     * @return BalanceTransaction
     * @throws Exception
     */
    public function StartNewTransactionBalanceProcess(BalanceTransaction $balanceTransaction): BalanceTransaction
    {
        $newTransactionBalance = $balanceTransaction->replicate()->fill(
            ["type" => $this->balanceTransactionStarterStatus]
        );
        $newTransactionBalance->save();
        return $newTransactionBalance;
    }

    public function afterJournalsHandler(BalanceTransaction $balanceTransaction)
    {
        $originalPayment = $balanceTransaction->transactionable;

        if (!$this->withLose || $originalPayment->fee == 0) {
            return;
        }

        $this->refundWithLoseProcess($balanceTransaction);

        $this->updatedPaymentAfterTransaction($originalPayment);
    }

    /**
     * @param BalanceTransaction $balanceTransaction
     */
    protected function refundWithLoseProcess(BalanceTransaction $balanceTransaction): void
    {
        $originalPayment = $balanceTransaction->transactionable;

        $journalLoseFee = $this->createNewJournal($balanceTransaction, JournalEnums::FEE_LOSS);

        $configuredAccount = Account::find(1); //todo: this should be configuration later;
        $debitCreditDetails = $configuredAccount->getIncomeAmountArray($originalPayment->fee);
        $transactionLose1 = $journalLoseFee->transactions()->create([
            "debit" => $debitCreditDetails["debit"],
            "credit" => $debitCreditDetails["credit"],
            "currency" => $originalPayment->currency,
            "fx_rate" => $originalPayment->fx_rate,
            "method" => "transfer",
            "account_id" => $configuredAccount->id
        ]);

        $configuredAccount = Account::find(2); //todo: this should be configuration later;
        $debitCreditDetails = $configuredAccount->getIncomeAmountArray($originalPayment->fee);
        $transactionLose2 = $journalLoseFee->transactions()->create([
            "debit" => $debitCreditDetails["debit"],
            "credit" => $debitCreditDetails["credit"],
            "currency" => $originalPayment->currency,
            "fx_rate" => $originalPayment->fx_rate,
            "method" => "transfer",
            "account_id" => $configuredAccount->id,
            "related_to" => $transactionLose1->id
        ]);
        $transactionLose1->related_to = $transactionLose2->id;
        $transactionLose1->save();
    }
}
