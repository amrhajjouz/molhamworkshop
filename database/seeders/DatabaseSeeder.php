<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\{User , Country , Cases , Section , Category};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        /////////////////// USER ////////////////////////
      
        DB::table('users')->insert([
            'name' => 'Developer User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
        ]);

        $mohamd = User::create([
            'name' => 'Mohamd Ghanoum',
            'email' => 'mohamd@admin.com',
            'password' => Hash::make('123123'),
        ]);

        ////////////// COUNTRY ///////////////////////
        $countries = [
            "syria" , "turkey" , "lebanon"  ,
        ];

        foreach($countries as $country){
            Country::create([
                "name" => $country
            ]);
        }


        //////////////// CASES ///////////
        $case = new Cases;
            $case ->country_id = 1;
            $case->beneficiary_name = "test name";
            $case->serial_number = "234323";
            $case->save();

        ////////////////// SECTION /////////////////

        $sections = [
            "القسم الطبي", "القسم الانساني", "قسم الحملات", "قسم الحماية", " قسم التعليم", "قسم المأوى",
        ];

        foreach($sections as $section){
            Section::create([
                'name' => $section
            ]);
        }

        ////////////////////CATEGORY ////////////////
        $categories = [
            'SponserShip'=>[
                ' كفالة يتيم' , 'طبية' , ' كفالة عائلة'
            ],
            'Cases' =>[
                'طبية' , 'انسانية'
            ],
            'Campaign'=>[
                'طبية' , 'اغاثية' , 'تعليم' , 'مأوى'
            ]
        ];

        foreach($categories as $created_for => $category){
            foreach($category as $item){
                Category::create([
                   'name'=> $item , 
                   'created_for' => $created_for
                ]);
             
            }
        }
    }
}
