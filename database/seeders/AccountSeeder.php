<?php

namespace Database\Seeders;

use App\Models\AccountBranch;
use App\Models\Currency;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
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
        for ($i = 1; $i <= 50; $i++) {
           $accountBranch =  AccountBranch::whereType("main")->inRandomOrder()->first();
           $currency = Currency::inRandomOrder()->first()->code;
           $count = count($accountBranch->childAccounts) + 1;
            DB::table('accounts')->insert([
                'name' => '{"ar": "'.$this->faker->word.'","ar": "'.$this->faker->word.'"}',
                'description' => '{"ar": "'.$this->faker->word.'","ar": "'.$this->faker->word.'"}',
                'branch_id' => $accountBranch->id,
                'code' => $accountBranch->code."-".$count,
                'country_code' => "AD",
                'currency' => $currency,
                'income' => 0,
                'outcome' => 0,
                'balance' => 0,
            ]);
        }
    }
}
