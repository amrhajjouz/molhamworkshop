<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Place::create(['name' => 'ادلب','type' => 'province','country_code' => "SY"]);
        Place::create(['name' => 'سراقب','type' => 'city','parent_id' => 1,]);
        Place::create(['name' => 'افس','type' => 'village','parent_id' => 2]);
        Place::create(['name' => 'بنش','type' => 'city']);
        Place::create(['name' => "جبلة",'type' => 'city']);
        Place::create(['name' => 'بانياس','type' => 'city']);
    }
}
