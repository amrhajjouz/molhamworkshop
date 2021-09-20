<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            CurrencySeeder::class,
            CountrySeeder::class,
            AccountSeeder::class
        ]);


        $this->call([
            CountrySeeder::class , 
            PlaceSeeder::class , 
        ]);
    }
}
