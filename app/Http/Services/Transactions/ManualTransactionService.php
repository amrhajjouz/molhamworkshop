<?php

namespace App\Http\Services\Transactions;

use App\Models\Account;
use App\Models\Donation;
use App\Models\Journals;
use App\Models\Payment;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\DB;

class ManualTransactionService extends TransactionService
{
    /**
     * @throws Exception
     */
    public function processManualPayment(Journals $journal)
    {
        try {
            $payment = $journal->journalable;
            $donations = $payment->donations;

            DB::beginTransaction();

            foreach ($donations as $donation) {
                $this->donationTransactionHandler($payment, $donation, $journal);
            }

            DB::commit();
        } catch (Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function processEPayment(Journals $journal)
    {
        try {
            $payment = $journal->journalable;
            $donations = $payment->donations;

            DB::beginTransaction();

            foreach ($donations as $donation) {
                $this->donationTransactionHandler($payment, $donation, $journal);
            }


            DB::commit();
        } catch (Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    private function EPaymentFeeTransactionsHandler(){

    }

    private function donationTransactionHandler(Payment $payment, Donation $donation, Journals $journal)
    {
        $paymentAccount = Account::find($payment->account_id);

        $paymentAccount->income($payment->amount);

        $deductionRatio = $donation->deductionRatio;

        $amountDetails = $this->calculateAmountAndDeductionRatio($donation->amount, $deductionRatio->ratio);

        $debitCreditDetails = $paymentAccount->getIncomeAmountArray($amountDetails["netAmount"]);
        //create net transaction to atef account
        $assetNetTransaction = $journal->transactions()->create([
            "debit" => $debitCreditDetails["debit"],
            "credit" => $debitCreditDetails["credit"],
            "currency" => $donation->currency,
            "fx_rate" => $payment->fx_rate,
            "method" => $payment->method,
            "account_id" => $payment->account_id
        ]);

        $paymentAccount->income($paymentAccount->amount);

        //create deduction transaction to atef account
        $assetDeductedTransaction = $journal->transactions()->create([
            "debit" => $debitCreditDetails["debit"],
            "credit" => $debitCreditDetails["credit"],
            "currency" => $donation->currency,
            "fx_rate" => $payment->fx_rate,
            "method" => $payment->method,
            "account_id" => $payment->account_id, //Atef account id
        ]);

        $paymentAccount->income($amountDetails["deductedAmount"]); //todo: check this again with amr

        $purposeAccount = $donation->purpose->account;

        $debitCreditDetails = $purposeAccount->getIncomeAmountArray($amountDetails["netAmount"]);
        //create normal transaction
        $liabilityNetTransaction = $journal->transactions()->create([
            "debit" => $debitCreditDetails["debit"],
            "credit" => $debitCreditDetails["credit"],
            "currency" => $donation->currency,
            "fx_rate" => $payment->fx_rate,
            "method" => $payment->method,
            "account_id" => $purposeAccount->id, //purpose account id
            "section_id" => $donation->section_id,
            "program_id" => $donation->program_id,
            "related_to" => $assetNetTransaction->id,
        ]);

        //create deduction transaction
        $liabilityDeductedTransaction = $journal->transactions()->create([
            "debit" => $debitCreditDetails["debit"],
            "credit" => $debitCreditDetails["credit"],
            "currency" => $donation->currency,
            "fx_rate" => $payment->fx_rate,
            "method" => $payment->method,
            "account_id" => $donation->deduction_account_id, //Deduction account id
            "section_id" => $donation->section_id,
            "program_id" => $donation->program_id,
            "related_to" => $assetDeductedTransaction->id,
        ]);

        $payment->update(["handled_at" => now()]);
    }
}
