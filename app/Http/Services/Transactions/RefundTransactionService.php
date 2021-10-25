<?php

namespace App\Http\Services\Transactions;

use App\Models\Account;
use App\Models\Journals;

class RefundTransactionService extends ReversalTransactionService
{
    protected $paymentTypeAfterTransaction = 'refunded';
    protected $journalStatusAfterTransaction = 'refund';
    private $allowLose = false;

    /**
     * @throws \Exception
     */
    public function processRefundTransaction (Journals $journal, $note, $allowLose){
        $this->allowLose =  $allowLose;
        $this->processTransaction($journal,$note);
    }

    public function afterJournalsHandler(Journals $journal){
        $originalPayment = $journal->journalable;

        if(!$this->allowLose || $originalPayment->fee == 0){
            return;
        }

        $this->refundJournalProcess($journal);
    }

    /**
     * @param Journals $journal
     * @param $originalPayment
     */
    protected function refundJournalProcess(Journals $journal): void
    {
        $originalPayment = $journal->journalable;
        $journalLoseFee = $journal->replicate()->create([
            'related_to' => $journal->id,
            'type' => "refund_losses_auto_journal",
        ]);

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
