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
        $this->call([
            UserSeeder::class,
            CountrySeeder::class,
            CurrencySeeder::class,
            AccountTypeSeeder::class,
            ReceiverSeeder::class,
            AccountsSeeder::class,
            DonorSeeder::class,
            PayoutRequestSeeder::class,
        ]);


        $this->call([
            CountrySeeder::class , 
            PlaceSeeder::class , 
        ]);
    }
}
