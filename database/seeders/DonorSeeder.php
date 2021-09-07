<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DonorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('donors')->insert([
            'name' => 'Mohammed Ghannoum',
            'email' => 'mohamd@admin.com',
            'verified' => 1,
            'password' => Hash::make('123123'),
        ]);
        
        DB::table('donors')->insert([
            'name' => 'Khaled',
            'email' => 'darkrideroffate@gmail.com',
            'password' => Hash::make('12345678'),
            'verified' => 1,
        ]);
        
        DB::table('donors')->insert([
            'name' => 'Mohammad',
            'email' => 'aliwi299@gmail.com',
            'password' => Hash::make('12345678'),
            'verified' => 1,
        ]);
        
        DB::table('donors')->insert([
            'name' => 'Amr',
            'email' => 'amr.hajjouz@gmail.com',
            'password' => Hash::make('12345678'),
            'verified' => 1,
        ]);
        
        for ($i=1; $i<=4; $i++) createRandomPaymentMethods($i);
    }
}
