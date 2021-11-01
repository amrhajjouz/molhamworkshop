<?php

namespace App\Http\Services\Transactions;

use App\Enums\BalanceTransactionEnums;
use App\Enums\JournalEnums;
use App\Enums\PaymentStatusEnums;
use App\Models\Account;
use App\Models\BalanceTransaction;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\DB;

class RefundTransactionService extends ReversalTransactionService
{
    protected $defaultStatusForNewJournals = JournalEnums::PAYMENT_REVERSAL;
    protected $newBalanceTransactionStatus = BalanceTransactionEnums::E_PAYMENT_FULL_REFUND;

    /**
     * @throws Exception
     */
    public function processRefundTransaction(Payment $payment, $note)
    {
        try {

            DB::beginTransaction();

            $allowedStatus = [PaymentStatusEnums::PAID, PaymentStatusEnums::PARTIALLY_REFUNDED];
            if (in_array($payment->type, $allowedStatus)) {
                throw new Exception("Full refund for payment id {$payment->id} is not allowed, the type of the required payment is {$payment->type}");
            }

            /**
             * Start reversing all journals and [fees ( if required )]
             */
             $newBalanceTransaction = $this->processTransaction($payment, $note);

            $reversed_fee = 0;
            if ($payment->isFeeRefundable()) {
                $this->processFeeLoseTransactions($newBalanceTransaction);
                $reversed_fee = $payment->fee;
            }
            /**
             * End processing all transactions and fees
             * At this point we did reversed everything, and we are still missing re-inserting the new journals  again
             */

            $payment->update([
                "reversed_amount" => $payment->amount,
                "reversed_fee" => $reversed_fee,
                "status" => PaymentStatusEnums::REFUNDED
            ]);

            DB::commit();
        } catch (Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param BalanceTransaction $newBalanceTransaction
     */
    protected function processFeeLoseTransactions(BalanceTransaction $newBalanceTransaction): void
    {
        $journalLoseFee = $this->createNewJournal($newBalanceTransaction, JournalEnums::FEE_LOSS);
        $originalPayment = $newBalanceTransaction->transactionable;

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

    /**
     * @param BalanceTransaction $balanceTransaction
     * @param string $note
     * @return BalanceTransaction
     * @throws Exception
     */
    public function StartNewTransactionBalanceProcess(BalanceTransaction $balanceTransaction, string $note): BalanceTransaction
    {
        $newTransactionBalance = $balanceTransaction->replicate()->fill([
            "type" => $this->newBalanceTransactionStatus,
            "notes" => $note,
            "handled_at" => now()
        ]);
        $newTransactionBalance->save();
        return $newTransactionBalance;
    }

    protected function isPaymentRequiredLoseFeeTransaction(Payment $payment): bool
    {
        $expectedReversedFee = ($payment->reversed_amount * $payment->amount) / $payment->fee;
        return $expectedReversedFee != $payment->reversed_fee;
    }
}
