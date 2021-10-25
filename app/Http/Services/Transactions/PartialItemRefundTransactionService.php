<?php

namespace App\Http\Services\Transactions;

use App\Models\Journals;
use Exception;

class  PartialItemRefundTransactionService extends RefundTransactionService
{
    protected $paymentTypeAfterTransaction = 'refunded';
    protected $journalStatusAfterTransaction = 'refund';
    protected $withLose = false;
    protected $donationsToRefund = [];

    /**
     * @throws Exception
     */
    public function processPartialRefundTransaction(Journals $journal, $note, array $donationsToRefund, $withLose)
    {
        $this->withLose = $withLose;
        $this->donationsToRefund = $donationsToRefund;
        $this->processTransaction($journal, $note);
    }

    protected function deleteSelectedDonations($donations): void
    {
        parent::deleteSelectedDonations($donations);

        $this->reInsertTheNewPartialRefund();
    }

    private function reInsertTheNewPartialRefund(){

    }

    public function afterJournalsHandler(Journals $journal)
    {
        parent::afterJournalsHandler($journal); // I might override this again in case of issue

        $this->reInsertPaymentTransactions($journal);
    }

    private function reInsertPaymentTransactions($journal)
    {
        $TransactionService = new TransactionService();
        $payment = $journal->journalable;

        //Create new Journal
        $journal = $payment->journal()->create([
            "type" => "e_payment", //todo later with the correct one if necessary
            "notes" => $journal->notes,
        ]);

        $TransactionService->processEPayment($journal);
    }
}
