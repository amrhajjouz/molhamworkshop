<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::create(['name' => 'US Dollar', 'symbol' => "$", 'symbol_native' => "$", 'code' => "USD"]);
        Currency::create(['name' => 'Euro', 'symbol' => "€", 'symbol_native' => "€", 'code' => "EUR"]);
        Currency::create(['name' => 'Turkish Lira', 'symbol' => "₺", 'symbol_native' => "₺", 'code' => "TRY"]);
        Currency::create(['name' => 'Saudi Riyal', 'symbol' => "SR", 'symbol_native' => "ر.س.", 'code' => "SAR"]);
        Currency::create(['name' => 'United Arab Emirates Dirham', 'symbol' => "AED", 'symbol_native' => "د.إ.", 'code' => "AED"]);
        Currency::create(['name' => 'Jordanian Dinar', 'symbol' => "JD", 'symbol_native' => "د.أ.‏", 'code' => "JOD"]);
    }
}
