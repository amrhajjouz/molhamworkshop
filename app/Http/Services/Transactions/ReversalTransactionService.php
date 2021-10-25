<?php

namespace App\Http\Services\Transactions;

use App\Models\Journals;
use Exception;
use Illuminate\Support\Facades\DB;

class ReversalTransactionService extends BaseTransactionService
{
    protected $paymentTypeAfterTransaction = 'reversal';
    protected $journalStatusAfterTransaction = 'reversal';

    /**
     * @throws Exception
     */
    public function processTransaction(Journals $journal, $note)
    {
        try {
            $payment = $journal->journalable;
            $donations = $payment->donations;

            DB::beginTransaction();

            $payment->status = $this->paymentTypeAfterTransaction; //todo: dynamic
            $payment->save();


            $this->deleteSelectedDonations($donations);
            $this->journalsHandler($journal, $note);

            DB::commit();
        } catch (Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function afterJournalsHandler(Journals $journal)
    {
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

    private function journalsHandler(Journals $journal, string $note)
    {
        $childJournal = $journal->childJournal;

        if ($childJournal != null) {
            $this->processJournal($childJournal, $note);
        }

        $this->processJournal($journal, $note);

        $this->afterJournalsHandler($journal);
    }

    /**
     * @param Journals $journal
     * @param string $note
     * @param $transactions
     * @param $originalPayment
     */
    private function processJournal(Journals $journal, string $note): void
    {
        $transactions = $journal->transactions;
        $originalPayment = $journal->journalable;

        if ($journal->type == "auto_fee") {
            $journalType = "auto_fees_reversal";
        } else {
            $journalType = $this->journalStatusAfterTransaction;
        }

        $reversalJournal = $journal->replicate()->fill([
            'notes' => $note,
            'related_to' => $journal->id,
            "type" => $journalType
        ]);
        $reversalJournal->save();

        foreach ($transactions as $transaction) {
            $originalPayment->reversed_amount += $transaction->amount;
            $debitCreditDetails = $transaction->account->getOutcomeAmountArray($transaction->amount);

            $reversalTransaction = $transaction->replicate()->fill([
                "related_to" => null,
                "debit" => -1 * $debitCreditDetails["debit"],
                "credit" => -1 * $debitCreditDetails["credit"],
            ]);

            $reversalTransaction->journal_id = $reversalJournal->id;

            $reversalJournal->transactions()->save($reversalTransaction);
        }

        $originalPayment->status = "partially_refunded"; //todo: move this to the top before deleting transactions
        $originalPayment->save();
    }
}
