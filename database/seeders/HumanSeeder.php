<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i<=100; $i++) {
            DB::table('humans')->insert([
                'name' => 'Name User ' . $i,
                'last_name' => 'Last Name User ' . $i,
                'father' => 'Father User ' . $i,
                'mother' => 'Mother User ' . $i,
                'email' => 'test' . $i . '@test.com',
            ]);
        }
    }
}
