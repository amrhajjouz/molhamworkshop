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
        Place::create(['name' => ['ar'=>'ادلب' , 'en'=>"idlep"],'type' => 'province','country_code' => "SY"]);
        Place::create(['name' =>['ar'=> 'سراقب' , 'en'=>'saraqep'] ,'type' => 'city','parent_id' => 1,]);
        Place::create(['name' => ['ar'=>'افس' , 'en'=>'afes'],'type' => 'village','parent_id' => 2]);
        Place::create(['name' =>['ar'=> 'بنش' , 'en' => 'Binnish'],'type' => 'city']);
        Place::create(['name' => ['ar'=>"جبلة" , 'en' => 'jablah'],'type' => 'city']);
        Place::create(['name' => ['ar' => 'بانياس' , 'en' => 'Bnias'] ,'type' => 'city']);
    }
}
