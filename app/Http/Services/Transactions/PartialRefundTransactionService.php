<?php

namespace App\Http\Services\Transactions;

use App\Models\Journals;
use Exception;

class PartialRefundTransactionService extends RefundTransactionService
{
    protected $paymentTypeAfterTransaction = 'refunded';
    protected $journalStatusAfterTransaction = 'refund';
    protected $allowLose = false;
    protected $donationsToRefund = [];

    /**
     * @throws Exception
     */
    public function processPartialRefundTransaction(Journals $journal, $note, array $donationsToRefund, $allowLose)
    {
        $this->allowLose = $allowLose;
        $this->donationsToRefund = $donationsToRefund;
        $this->processTransaction($journal, $note);
    }

    protected function deleteSelectedDonations($donations): void
    {
        foreach ($donations as $donation) {
            if (in_array($donation->id, $this->donationsToRefund)) {
                $donation->delete();
            }
        }
    }

    public function afterJournalsHandler(Journals $journal)
    {
        parent::afterJournalsHandler($journal); //todo: confirm the flow here again

        $this->reInsertPaymentTransactions($journal);
    }

    private function reInsertPaymentTransactions($journal)
    {
        $manualTransactionService = new TransactionService();
        $payment = $journal->journalable;

        //Create new Journal
        $journal = $payment->journal()->create([
            "type" => "e_payment", //todo later with the correct one if necessary
            "notes" => $journal->notes,
        ]);

        $manualTransactionService->processEPayment($journal);
    }
}
