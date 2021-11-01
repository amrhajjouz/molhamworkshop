<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\DeductionRatios;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeductionRatioSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            $account = Account::inRandomOrder()->first();
            DB::table('deduction_ratios')->insert([
                'name' => '{"ar": "deduction ' . $this->faker->word . '","ar": "deduction ' . $this->faker->word . '"}',
                'description' => '{"ar": "' . $this->faker->word . '","ar": "' . $this->faker->word . '"}',
                'ratio' => rand(1, 10),
                'account_id' => $account->id,
            ]);
        }

        $accounts = Account::all();

        foreach ($accounts as $account) {
            $deductionRatios = DeductionRatios::inRandomOrder()->first();

            if ($account->id == $deductionRatios->account_id) {
                continue;
            }
            $account->update(["default_deduction_ratio_id" => $deductionRatios->id]);
        }
    }
}
