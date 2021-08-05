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

        DB::table('users')->insert([
            'name' => 'Mohand ghannum ',
            'email' => 'mohamd@admin.com',
            'password' => Hash::make('123123'),
        ]);

        for ($i=1; $i<=10; $i++) {
            DB::table('users')->insert([
                'name' => 'Test User ' . $i,
                'email' => 'test' . $i . '@test.com',
                'password' => Hash::make('12345678'),
            ]);
        }
    }
}
