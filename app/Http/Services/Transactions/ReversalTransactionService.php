<?php

namespace App\Http\Services\Transactions;

use App\Models\Journals;
use Exception;
use Illuminate\Support\Facades\DB;

class ReversalTransactionService extends TransactionService
{
    /**
     * @throws Exception
     */
    public function processReversalTransaction(Journals $journal, $note)
    {
        try {
            $payment = $journal->journalable;
            $donations = $payment->donations;

            DB::beginTransaction();

            $payment->status = "reversal";
            $payment->save();

            foreach ($donations as $donation) {
                $donation->delete();
            }

            $this->reversalTransactionHandler($journal, $note);

            DB::commit();
        } catch (Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    private function reversalTransactionHandler(Journals $journal, string $note)
    {
        $transactions = $journal->transactions;

        $reversalJournal = $journal->replicate()->fill([
            'notes' => $note,
            'related_to' => $journal->id,
        ]);

        $reversalJournal->type = "reversal";

        $reversalJournal->save();

        foreach ($transactions as $transaction) {

            $reversalTransaction = $transaction->replicate()->fill([
                "related_to" => null,
                "amount" => -1 * $transaction->amount,
            ]);

            $reversalJournal->transactions()->save($reversalTransaction);
        }
    }
}
