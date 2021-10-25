<?php


namespace App\Http\Controllers\Services;

use App\Models\Account;
use App\Models\ReceiverTransaction;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ReceivedTransactionService
{
    public function handleTransaction($transaction)
    {
        try {
            if ($transaction["from"] == $transaction["to"]) {
                throw new Exception("you can't exchange between same accounts");
            }

            if (!isset($transaction["notes"])) {
                $transaction["notes"] = null;
            }

            $accounts = Account::whereIn("id", [$transaction["from"], $transaction["to"]])
                ->onlyActive()
                ->get();
            $outcomeAccount = $accounts->Where("id", $transaction["from"])->first();
            $IncomeAccount = $accounts->Where("id", $transaction["to"])->first();

            if ($outcomeAccount->left < $transaction["amount"]) {
                throw new Exception("Account {$outcomeAccount->name} has insufficient funds");
            }

            DB::beginTransaction();

            if ($transaction["type"] == "exchange") {
                $this->processExchange($outcomeAccount, $IncomeAccount, $transaction);
            }

            if ($transaction["type"] == "transfer") {
                $this->processTransfer($outcomeAccount, $IncomeAccount, $transaction);
            }

            DB::commit();
        } catch (\Exception  $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    private function processExchange($outcomeAccount, $incomeAccount, $transaction)
    {
        if ($outcomeAccount->receiver_id != $incomeAccount->receiver_id) {
            throw new Exception("You can't exchange between two different receivers");
        }
        if ($outcomeAccount->currency == $incomeAccount->currency) {
            throw new Exception("You can't exchange to the same currency");
        }

        $exchange = $this->calculateRate($transaction["amount"], $outcomeAccount->currency, $incomeAccount->currency);
        $outTransaction = new ReceiverTransaction();
        $outTransaction->type = $transaction["type"];
        $outTransaction->currency = $outcomeAccount->currency;
        $outTransaction->amount = $transaction["amount"] * -1;
        $outTransaction->usd_rate = $exchange["usd_rate"];
        $outTransaction->notes = $transaction["notes"];
        $outcomeAccount->AddTransaction($outTransaction);

        $incomeTransaction = $outTransaction->replicate();
        $incomeTransaction->type = $transaction["type"];
        $incomeTransaction->currency = $incomeAccount->currency;
        $incomeTransaction->amount = $exchange["amount"];
        $incomeTransaction->related_to = $outTransaction->id;
        $incomeAccount->AddTransaction($incomeTransaction);

        $outTransaction->update(["related_to" => $incomeTransaction->id]);
    }

    private function calculateRate($amount, $from, $to): array
    {
        $rate = 1.00;
        return ["amount" => $amount * $rate, "usd_rate" => $rate]; //todo : change this to handle the exchange price, now I'm assuming it's 1 : 1
    }

    private function processTransfer($outcomeAccount, $incomeAccount, $transaction)
    {
        if ($incomeAccount->currency != $outcomeAccount->currency) {
            throw new Exception("You can't transfer money between two different currency");
        }

        $outTransaction = new ReceiverTransaction();
        $outTransaction->type = $transaction["type"];
        $outTransaction->currency = $outcomeAccount->currency;
        $outTransaction->amount = $transaction["amount"] * -1;
        $outTransaction->usd_rate = 1; //check this in transfer
        $outTransaction->notes = $transaction["notes"];
        $outcomeAccount->AddTransaction($outTransaction);

        $incomeTransaction = $outTransaction->replicate();
        $incomeTransaction->type = $transaction["type"];
        $incomeTransaction->currency = $incomeAccount->currency;
        $incomeTransaction->amount = $transaction["amount"];
        $incomeTransaction->related_to = $outTransaction->id;
        $incomeAccount->AddTransaction($incomeTransaction);

        $outTransaction->update(["related_to" => $incomeTransaction->id]);

    }


}
