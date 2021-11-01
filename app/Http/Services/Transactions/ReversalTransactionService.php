<?php

namespace App\Http\Services\Transactions;

use App\Enums\BalanceTransactionEnums;
use App\Enums\JournalEnums;
use App\Enums\PaymentStatusEnums;
use App\Models\BalanceTransaction;
use App\Models\Journals;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\DB;

class ReversalTransactionService extends BaseTransactionService
{
    protected $paymentTypeAfterTransaction = PaymentStatusEnums::REVERSED;
    protected $defaultStatusForNewJournals = JournalEnums::PAYMENT_REVERSAL;

    /**
     * @throws Exception
     */
    public function processReversalTransaction(Payment $payment, $note)
    {
        try {
            DB::beginTransaction();

            $newBalanceTransaction = $this->processTransaction($payment, $note);

            $this->updatedPaymentAfterTransaction($newBalanceTransaction->transactionable);

            DB::commit();

        } catch (Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function processTransaction(Payment $payment, $note): BalanceTransaction
    {
        $donations = $payment->donations;

        $originBalanceTransaction = $this->getOriginBalanceTransactionFromPayment($payment);

        $this->deleteSelectedDonations($donations);

        return $this->balanceTransactionHandler($originBalanceTransaction, $note);
    }

    protected function updatedPaymentAfterTransaction(Payment $payment)
    {
        $payment->update([
            "reversed_amount" => $payment->amount,
            "status" => $this->paymentTypeAfterTransaction
        ]);
    }

    /**
     * @param Payment $payment
     * @return mixed
     * @todo: check this with amr, we might need to do some flagging to not get wrong balance
     */
    protected function getOriginBalanceTransactionFromPayment(Payment $payment)
    {
        return $payment->balanceTransactions->where("type", BalanceTransactionEnums::E_PAYMENT)->last();
    }

    /**
     * @param $donations
     */
    protected function deleteSelectedDonations($donations): void
    {
        foreach ($donations as $donation) {
            $donation->delete();
        }
    }

    /**
     * @throws Exception
     */
    private function balanceTransactionHandler(BalanceTransaction $originBalanceTransaction, string $note): BalanceTransaction
    {
        $originalJournals = $originBalanceTransaction->journals->reverse(); // we reverse to start from the bottom to the top

        $newTransactionBalance = $this->StartNewTransactionBalanceProcess($originBalanceTransaction, $note); // create new balance transaction to group all the process from here

        //reverse the status of all origin journals
        foreach ($originalJournals as $journal) {
            $this->processJournal($journal, $newTransactionBalance);
        }

        return $newTransactionBalance;
    }

    /**
     * @param BalanceTransaction $balanceTransaction
     * @param string $note
     * @return BalanceTransaction
     * @throws Exception
     */
    public function StartNewTransactionBalanceProcess(BalanceTransaction $balanceTransaction, string $note): BalanceTransaction
    {
        if ($balanceTransaction->type == BalanceTransactionEnums::MANUAL_PAYMENT) {
            $newBalanceTransactionStatus = BalanceTransactionEnums::MANUAL_PAYMENT_REVERSAL;
        } else if ($balanceTransaction->type == BalanceTransactionEnums::E_PAYMENT) {
            $newBalanceTransactionStatus = BalanceTransactionEnums::E_PAYMENT_PAYMENT_REVERSAL;
        } else {
            throw new Exception("unexpected balance transaction type {$balanceTransaction->type} for {$balanceTransaction->id}");
        }

        $newTransactionBalance = $balanceTransaction->replicate()->fill([
            "type" => $newBalanceTransactionStatus,
            "notes" => $note,
            "handled_at"=>now()
        ]);
        $newTransactionBalance->save();
        return $newTransactionBalance;
    }

    /**
     * @param Journals $journal
     * @param BalanceTransaction $newTransactionBalance
     * @note we do [reverse,refund] each journal in a row . and then we assign the value to the new created [balance_transaction]
     */
    private function processJournal(Journals $journal, BalanceTransaction $newTransactionBalance): void
    {
        $transactions = $journal->transactions;

        if ($journal->type == JournalEnums::AUTO_FEE) {
            $journalType = JournalEnums::AUTO_FEE_REVERSAL;
        } else {
            $journalType = $this->defaultStatusForNewJournals;
        }

        $reversalJournal = $this->createNewJournal($newTransactionBalance, $journalType);

        foreach ($transactions as $transaction) {
            $debitCreditDetails = $transaction->account->getOutcomeAmountArray($transaction->amount);

            $reversalTransaction = $transaction->replicate()->fill([
                "related_to" => null,
                "debit" => -1 * $debitCreditDetails["debit"],
                "credit" => -1 * $debitCreditDetails["credit"],
                "journal_id" => $reversalJournal->id
            ]);

            $reversalJournal->transactions()->save($reversalTransaction);
        }
    }
}
