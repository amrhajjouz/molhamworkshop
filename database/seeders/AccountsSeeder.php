<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('r_accounts')->insert([
            [
                'name' => 'حساب دولار',
                'currency' => 'USD',
                'initial_balance' => '9999',
                'income' => '0',
                'outcome' => '0',
                'left' => '9999',
                'type_id' => '1',
                'receiver_id' => '1',
            ],
            [
                'name' => 'حساب تركي',
                'currency' => 'TRY',
                'initial_balance ' => '99999',
                'income' => '0',
                'outcome' => '0',
                'left' => '99999',
                'type_id' => '1',
                'receiver_id' => '1',
            ],
            [
                'name' => 'حساب دولار',
                'currency' => 'USD',
                'initial_balance ' => '9999',
                'income' => '0',
                'outcome' => '0',
                'left' => '9999',
                'type_id' => '1',
                'receiver_id' => '2',
            ],
            [
                'name' => 'حساب تركي',
                'currency' => 'TRY',
                'initial_balance ' => '99999',
                'income' => '0',
                'outcome ' => '0',
                'left ' => '99999',
                'type_id  ' => '1',
                'receiver_id' => '2',
            ]
        ]);
    }
}
