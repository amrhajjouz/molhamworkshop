<?php

namespace App\Http\Controllers\Services;

use App\Models\Account;
use App\Models\Payment;
use App\Models\PaymentTransaction;
use App\Models\ReceiverTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mockery\Exception;

class PaymentTransactionService
{
    public function CreateTransaction($transaction)
    {
        try {
            if (!isset($transaction["notes"])) {
                $transaction["notes"] = null;
            }

            $account = Account::Where("id", [$transaction["account_id"]])
                ->onlyActive()
                ->first();

            if ($account == null) { //in case the account is not active
                throw new Exception("the requested account is not active");
            }

            if ($account->currency != $transaction["currency"]) {
                throw new Exception("the chosen account has different currency");
            }

            $transaction["received_at"] = date("Y-m-d", strtotime($transaction["received_at"]));

            $totalAmount = collect($transaction["purposes"])->sum("amount");

            DB::beginTransaction();

            $receiverTransaction = ReceiverTransaction::create(array(
                "amount" => $totalAmount,
                "currency" => $transaction["currency"],
                "account_id" => $transaction["account_id"],
                "type" => "payment",
                "usd_rate" => $transaction["usd_rate"],
                "notes" => $transaction["notes"],
                "related_to" => null,
            ));

            $account->fresh();
            $account->fixIncomeOutcome();

            $payment = $receiverTransaction->payment()
                ->create(array(
                    "amount" => $totalAmount,
                    "currency" => $transaction["currency"],
                    "status" => "paid",
                    "type" => "payment",
                    "usd_rate" => $transaction["usd_rate"],
                    "received_at" => $transaction["received_at"],
                    "notes" => $transaction["notes"],
                    "donor_id" => $transaction["donor_id"],
                    "reference" => Str::uuid(),
                ));

            foreach ($transaction["purposes"] as $purpose) {

                $amount = $purpose["amount"] / $transaction["usd_rate"];
                $paymentTransaction = PaymentTransaction::create(array(
                    "type" => "donation",
                    "purpose_type" => $purpose["purpose_type"],
                    "purpose_id" => null, //todo later when we got the merged mr for the other stuff
                    "amount" => $amount,//in dollar
                    "notes" => $transaction["notes"],
                ));

                $payment->donations()
                    ->create(array(
                        "amount" => $purpose["amount"],
                        "currency" => $transaction["currency"],
                        "status" => "paid",
                        "type" => "payment",
                        "usd_rate" => $transaction["usd_rate"],
                        "received_at" => $transaction["received_at"],
                        "notes" => $transaction["notes"],
                        "donor_id" => $transaction["donor_id"],
                        "country_id" => $transaction["country_id"],
                        "payment_transaction_id" => $paymentTransaction->id,
                        "reference" => Str::uuid(),
                    ));
            }

            DB::commit();
        } catch (\Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function TransferTransaction(array $transaction)
    {
        try {
            if (!isset($transaction["notes"])) {
                $transaction["notes"] = null;
            }
            DB::beginTransaction();
            $transferFrom = PaymentTransaction::create(array(
                "amount" => $transaction["amount"] * -1,
                "notes" => $transaction["notes"],
                "type" => "transfer",
                "purpose_type" => $transaction["from"],
                "purpose_id" => null,
                "related_to" => null,
            ));

            $transferTo = PaymentTransaction::create(array(
                "amount" => $transaction["amount"],
                "notes" => $transaction["notes"],
                "type" => "transfer",
                "purpose_type" => $transaction["to"],
                "purpose_id" => null,
                "related_to" => $transferFrom->id,
            ));
            $transferFrom->update(["related_to" => $transferTo->id]);
            DB::commit();
        } catch (\Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function DeleteTransaction($transactionId)
    {
        try {
            DB::beginTransaction();
            $transaction = PaymentTransaction::with("donation.payment.receiverTransaction.account")->find($transactionId);

            if ($transaction->type != "transfer") {
                throw new Exception("Only Transfer transactions are allowed for this action");
            }
            $transaction->transactionRelated->delete();
            $transaction->delete();
            DB::commit();
        } catch (\Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function DeletePayment($paymentId)
    {
        try {
            //todo add a check to make sure the user can't delete un cash type payment .
            DB::beginTransaction();
            $payment = Payment::with("receiverTransaction.account", "donations.transaction")->find($paymentId);
            $payment->donations->each(function ($donation) {
                $donation->transaction->delete();
            });
            $payment->donations->each->delete();
            $payment->receiverTransaction->delete();
            $payment->delete();
            $account = $payment->receiverTransaction->account;
            $account->fresh();
            $account->fixIncomeOutcome();
            DB::commit();
        } catch (\Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
