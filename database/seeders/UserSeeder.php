<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i<=500; $i++) {
            DB::table('users')->insert([
                'name' => 'Test User ' . $i,
                'email' => 'test' . $i . '@test.com',
                'password' => Hash::make('12345678'),
                'locale' => 'ar',
            ]);
        }
    }
}
