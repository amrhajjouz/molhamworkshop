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
        Place::create(['name' => ['ar'=>'ادلب' , 'en'=>"Idlep"], 'country_code' => "SY"]);
        Place::create(['name' => ['ar'=>'دمشق' , 'en'=>"Damascus"], 'country_code' => "SY"]);
        Place::create(['name' => ['ar'=>'اللاذقية' , 'en'=>"Lattakia"], 'country_code' => "SY"]);
        Place::create(['name' => ['ar'=>'حلب' , 'en'=>"Aleppo"], 'country_code' => "SY"]);
        Place::create(['name' => ['ar'=>'ديرالزور' , 'en'=>"Dir Alzor"], 'country_code' => "SY"]);
        Place::create(['name' => ['ar'=>'حمص' , 'en'=>"Homs"], 'country_code' => "SY"]);
        Place::create(['name' => ['ar'=>'حماه' , 'en'=>"Hama"], 'country_code' => "SY"]);
        
        Place::create(['name' => ['ar'=>'اسطنبول' , 'en'=>"Istanbul"], 'country_code' => "TR"]);
        Place::create(['name' => ['ar'=>'غازي عينتاب' , 'en'=>"Gaziantep"], 'country_code' => "TR"]);
        Place::create(['name' => ['ar'=>'هاتاي' , 'en'=>"Hatay"], 'country_code' => "TR"]);
        Place::create(['name' => ['ar'=>'أنقرة' , 'en'=>"Ankara"], 'country_code' => "TR"]);

        Place::create(['name' =>['ar'=> 'سراقب' , 'en'=>'saraqep'] , 'parent_id' => 1,'country_code' => "SY" ]);
        Place::create(['name' => ['ar'=>'افس' , 'en'=>'afes'] ,'parent_id' => 1 , 'country_code' => "SY"]);
        Place::create(['name' =>['ar'=> 'بنش' , 'en' => 'Binnish'],'country_code' => "SY"]);
        Place::create(['name' => ['ar'=>"جبلة" , 'en' => 'jablah'],'country_code' => "SY"]);
        Place::create(['name' => ['ar' => 'بانياس' , 'en' => 'Bnias'] ,'country_code' => "SY"]);
    }
}
