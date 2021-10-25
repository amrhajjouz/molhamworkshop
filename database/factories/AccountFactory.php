<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Model;
use App\Models\Receiver;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $result = [
            'name' => $this->faker->name,
            'currency' => $this->faker->randomElement(["TRY", "USD"]),
            'initial_balance' => $this->faker->randomElement([0, 9999.00]),
            'income' => 0.00,
            'outcome' => 0.00,
            'left' => function (array $attributes) {
                return $attributes['initial_balance'];
            },
            'type_id' => AccountType::factory(),
            'receiver_id' => Receiver::Factory(),
        ];
        return $result;
    }
}
