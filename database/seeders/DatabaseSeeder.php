<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Developer User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
        ]);

        DB::table('users')->insert([
            'name' => 'Mohammed Ghannoum',
            'email' => 'mohamd@admin.com',
            'password' => Hash::make('123123'),
        ]);


        $this->call([
            UserSeeder::class,
            NotificationPrefernceSeeder::class,
            DonorSeeder::class,
        ]);
    }
}
