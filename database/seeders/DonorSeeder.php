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
            'password' => Hash::make('123123'),
        ]);
    }
}
