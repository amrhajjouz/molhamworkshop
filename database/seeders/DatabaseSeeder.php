<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\{User , Country , Cases , Section , Category , Place , Donor};

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
            "سوريا" , "تركيا" , "لبنان"  ,
        ];

        foreach($countries as $country){
            Country::create([
                "name" => $country
            ]);
        }



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
            'Sponsorships'=>[
                ' كفالة يتيم' , 'طبية' , ' كفالة عائلة' 
            ],
            'Cases' =>[
                'طبية' , 'انسانية'
            ],
            'Campaigns'=>[
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

        /////////////////////// Place /////////////////////////

        $idlep = Place::create([
            'name' => 'ادلب' , 
            'type' => 'province' , 
            'country_id' => Country::where('name' , 'سوريا')->first()->id , 
        ]);
        $saraqep = Place::create([
            'name' => 'سراقب' , 
            'type' => 'city' , 
            'parent_id' => $idlep->id , 

        ]);
        $saraqep = Place::create([
            'name' => 'افس' , 
            'type' => 'village' , 
            'parent_id' => $saraqep->id , 

        ]);
        
        Place::create([
            'name' => 'بنش' , 
            'type' => 'city' , 
        ]);
        Place::create([
            'name' => "جبلة" , 
            'type' => 'city' , 
        ]);
        Place::create([
            'name' => 'sadfgh' , 
            'type' => 'city' , 
        ]);

        /////////////////////// DONOR /////////////////////////

        Donor::create([
            'name' => 'donor1',
            'email' => 'donor1@donor.com',
            'password' => Hash::make(12345678),
            'email' => 'donor1@donor.com',
        ]);
       
        Donor::create([
            'name' => 'donor2',
            'email' => 'donor2@donor.com',
            'password' => Hash::make(12345678),
            'email' => 'donor1@donor.com',
        ]);
        
        
    }
}
