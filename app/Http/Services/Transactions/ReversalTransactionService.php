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
    protected $journalStatusAfterTransaction = JournalEnums::PAYMENT_REVERSAL;

    /**
     * @throws Exception
     */
    public function processTransaction(Payment $payment, $note)
    {
        try {
            $donations = $payment->donations;

            //todo: check this with amr, we might need to do some flagging to not get wrong balance
            $balanceTransactions = $payment->balanceTransactions->where("type", BalanceTransactionEnums::E_PAYMENT)->last(); //TODO : GET THE FIRST BALANCE TRANSACTION OF TYPE PAYMENT THEN REFUND

            DB::beginTransaction();

            $payment->status = $this->paymentTypeAfterTransaction; //todo: dynamic
            $payment->save();

            $this->deleteSelectedDonations($donations);

            $this->balanceTransactionHandler($balanceTransactions, $note);

            DB::commit();
        } catch (Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param BalanceTransaction $balanceTransaction
     * @return BalanceTransaction
     * @throws Exception
     */
    public function StartNewTransactionBalanceProcess(BalanceTransaction $balanceTransaction): BalanceTransaction
    {
        if ($balanceTransaction->type == BalanceTransactionEnums::MANUAL_PAYMENT) {
            $newBalanceTransactionStatus = BalanceTransactionEnums::MANUAL_PAYMENT_REVERSAL;
        } else if ($balanceTransaction->type == BalanceTransactionEnums::E_PAYMENT) {
            $newBalanceTransactionStatus = BalanceTransactionEnums::E_PAYMENT_PAYMENT_REVERSAL;
        } else {
            throw new Exception("unexpected balance transaction type {$balanceTransaction->type} for {$balanceTransaction->id}");
        }

        $newTransactionBalance = $balanceTransaction->replicate()->fill(
            ["type" => $newBalanceTransactionStatus]
        );
        $newTransactionBalance->save();
        return $newTransactionBalance;
    }

    protected function afterJournalsHandler(BalanceTransaction $balanceTransaction)
    {
        $this->updatedPaymentAfterTransaction($balanceTransaction->transactionable);
    }

    protected function updatedPaymentAfterTransaction(Payment $payment)
    {
        $payment->update(["reversed_amount" => $payment->amount]);
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
    private function balanceTransactionHandler(BalanceTransaction $balanceTransaction, string $note)
    {
        $journals = $balanceTransaction->journals;

        $newTransactionBalance = $this->StartNewTransactionBalanceProcess($balanceTransaction);

        //todo:check if we can reverse the array at the bottom
        foreach ($journals as $journal) { //start from the bottom to the top
            $this->processJournal($journal, $newTransactionBalance);
        }

        $this->afterJournalsHandler($newTransactionBalance);
    }

    /**
     * @param Journals $journal
     * @param string $note
     * @param $transactions
     * @param $originalPayment
     */
    private function processJournal(Journals $journal, BalanceTransaction $newTransactionBalance): void
    {
        $transactions = $journal->transactions;
        $originalPayment = $newTransactionBalance->transactionable;

        if ($journal->type == JournalEnums::AUTO_FEE) {
            $journalType = JournalEnums::AUTO_FEE_REVERSAL;
        } else {
            $journalType = $this->journalStatusAfterTransaction;
        }

        $reversalJournal = $this->createNewJournal($newTransactionBalance, $journalType);

        foreach ($transactions as $transaction) {
            $debitCreditDetails = $transaction->account->getOutcomeAmountArray($transaction->amount);

            $reversalTransaction = $transaction->replicate()->fill([
                "related_to" => null,
                "debit" => -1 * $debitCreditDetails["debit"],
                "credit" => -1 * $debitCreditDetails["credit"],
            ]);

            $reversalTransaction->journal_id = $reversalJournal->id;

            $reversalJournal->transactions()->save($reversalTransaction);
        }
    }
}
