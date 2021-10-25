<?php

namespace App\Http\Services\Transactions;

use App\Models\Account;
use App\Models\Journals;

class RefundTransactionService extends ReversalTransactionService
{
    protected $paymentTypeAfterTransaction = 'refunded';
    protected $journalStatusAfterTransaction = 'refund';
    protected $withLose = false;

    /**
     * @throws \Exception
     */
    public function processRefundTransaction (Journals $journal, $note, $allowLose){
        $this->withLose =  $allowLose;
        $this->processTransaction($journal,$note);
    }

    public function afterJournalsHandler(Journals $journal){
        $originalPayment = $journal->journalable;

        if(!$this->withLose || $originalPayment->fee == 0){
            return;
        }

        $this->refundWithLoseProcess($journal);
    }

    /**
     * @param Journals $journal
     * @param $originalPayment
     */
    protected function refundWithLoseProcess(Journals $journal): void
    {
        $originalPayment = $journal->journalable;
        $journalLoseFee = $journal->replicate()->fill([
            'related_to' => $journal->id,
            'type' => "refund_losses_auto_journal",
        ]);
        $journalLoseFee->save();

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
