<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\ReceiverTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceiverTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReceiverTransaction::class;
    private $currencies = ["TRY", "USD"];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $result = [
            'type' => $this->faker->randomElement(["transfer", "exchange"]),
            'currency' => $this->faker->randomElement($this->currencies),
            'amount' => -1,
            'account_id' => Account::factory(),
            'usd_rate' => 1,
            'notes' => "whatever",
        ];
        return $result;
    }

    public function configure()
    {
        return $this->afterMaking(function (ReceiverTransaction $transaction) {

//
        })->afterCreating(function (ReceiverTransaction $transaction) {
            if ($transaction->amount > 0) {
                return;
            }
            $parentCurrency = $transaction->currency;
            if ($transaction->type == "exchange") {
                $childCurrency = $parentCurrency == "USD" ? "TRY" : "USD";
                $relatedTransaction = ReceiverTransaction::factory()->create([
                    "type" => "exchange",
                    "account_id" => $transaction->account_id,
                    "currency" => $childCurrency,
                    "related_to" => $transaction->id,
                    "amount" => 1
                ]);

                $transaction->update(["related_to" => $relatedTransaction->id]);
                Account::find($transaction->account_id)->fixIncomeOutcome();

            } else if ($transaction->type == "transfer") {
                $relatedTransaction = ReceiverTransaction::factory()->create([
                    "type" => "transfer",
                    "currency" => $parentCurrency,
                    "related_to" => $transaction->id,
                    "amount" => 1
                ]);
                $transaction->update(["related_to" => $relatedTransaction->id]);
            }
            Account::find($transaction->account_id)->fixIncomeOutcome();
            Account::find($relatedTransaction->account_id)->fixIncomeOutcome();
        });
    }
}
