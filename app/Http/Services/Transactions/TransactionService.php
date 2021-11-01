<?php

namespace App\Http\Services\Transactions;

use App\Enums\JournalEnums;
use App\Models\Account;
use App\Models\BalanceTransaction;
use App\Models\Donation;
use App\Models\Journals;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionService extends BaseTransactionService
{
    /**
     * @throws Exception
     */
    public function processPayment(BalanceTransaction $balanceTransaction)
    {
        try {
            $payment = $balanceTransaction->transactionable;
            $donations = $payment->donations;

            DB::beginTransaction();

            $journal = $this->createNewJournal($balanceTransaction, JournalEnums::PAYMENT);

            //we don't have any new journal inside here
            foreach ($donations as $donation) {
                $this->donationTransactionHandler($payment, $donation, $journal);
            }

            if ($payment->fee > 0) {
                $this->handleEPaymentExtraFee($balanceTransaction);
            }

            $balanceTransaction->update(["handled_at" => now()]);

            DB::commit();
        } catch (Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function donationTransactionHandler(Payment $payment, Donation $donation, Journals $journal)
    {
        $paymentAccount = Account::find($payment->account_id);
        $purposeAccount = $donation->purpose->account;
        $deductionRatio = $donation->deductionRatio;

        /**
         * first we create two net transactions one to Atef and the second to the purpose account id
         **/
        $amountDetails = $this->calculateAmountAndDeductionRatio($donation->amount, $deductionRatio->ratio);
        $debitCreditDetails = $paymentAccount->getIncomeAmountArray($amountDetails["netAmount"]);
        $assetNetTransaction = $journal->transactions()->create([
            "debit" => $debitCreditDetails["debit"],
            "credit" => $debitCreditDetails["credit"],
            "currency" => $donation->currency,
            "fx_rate" => $payment->fx_rate,
            "method" => $payment->method,
            "account_id" => $payment->account_id
        ]);

        //create normal transaction
        $debitCreditDetails = $purposeAccount->getIncomeAmountArray($amountDetails["netAmount"]);
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
        $assetNetTransaction->related_to = $liabilityNetTransaction->id;
        $assetNetTransaction->save();

        /**
         *  we create two deducted transactions one to Atef and the second to the deducted account id
         **/
        //create deduction transaction to atef account
        $debitCreditDetails = $paymentAccount->getIncomeAmountArray($amountDetails["deductedAmount"]);
        $assetDeductedTransaction = $journal->transactions()->create([
            "debit" => $debitCreditDetails["debit"],
            "credit" => $debitCreditDetails["credit"],
            "currency" => $donation->currency,
            "fx_rate" => $payment->fx_rate,
            "method" => $payment->method,
            "account_id" => $payment->account_id, //Atef account id
        ]);

        //create deduction transaction
        $debitCreditDetails = $purposeAccount->getIncomeAmountArray($amountDetails["deductedAmount"]);
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
        $assetDeductedTransaction->related_to = $liabilityDeductedTransaction->id;
        $assetDeductedTransaction->save();
    }

    private function handleEPaymentExtraFee(BalanceTransaction $balanceTransaction)
    {
        $payment = $balanceTransaction->transactionable;

        $journalExtraFee = $this->createNewJournal($balanceTransaction, JournalEnums::AUTO_FEE);

        foreach ($payment->donations as $donation) {
            $purposeAccount = $donation->purpose->account;
            $amountDetails = $this->calculateAmountAndDeductionRatio($donation->amount, $donation->getEPaymentExtraFee());
            $debitCreditDetails = $purposeAccount->getIncomeAmountArray($amountDetails["deductedAmount"]);
            //create deduction transaction
            $deductedTransaction = $journalExtraFee->transactions()->create([
                "debit" => $debitCreditDetails["debit"],
                "credit" => $debitCreditDetails["credit"],
                "currency" => $donation->currency,
                "fx_rate" => $payment->fx_rate,
                "method" => "transfer",
                "account_id" => $donation->deduction_account_id, //Deduction account id
                "section_id" => $donation->section_id,
                "program_id" => $donation->program_id,
            ]);

            //the next line is wrong , just temporary solution
            $liabilitiesAccount = $donation->purpose->account; //todo: I should do a special query here to get the extra account we need
            $debitCreditDetails = $liabilitiesAccount->getIncomeAmountArray($amountDetails["deductedAmount"]);
            $liabilityDeductedTransaction = $journalExtraFee->transactions()->create([
                "debit" => $debitCreditDetails["debit"],
                "credit" => $debitCreditDetails["credit"],
                "currency" => $donation->currency,
                "fx_rate" => $payment->fx_rate,
                "method" => "transfer",
                "account_id" => $liabilitiesAccount->id,
                "section_id" => $donation->section_id,
                "program_id" => $donation->program_id,
                "related_to" => $deductedTransaction->id
            ]);

            $deductedTransaction->related_to = $liabilityDeductedTransaction->id;
            $deductedTransaction->save();
        }
    }
}
