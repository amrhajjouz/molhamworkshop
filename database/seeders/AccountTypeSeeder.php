<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('r_accounts_types')->insert([ // todo : ask amr about the values here
            ['name' => 'A'],
            ['name' => 'B'],
            ['name' => 'C'],
        ]);
    }
}
