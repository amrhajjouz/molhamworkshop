<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\{User , Country};

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
    }
}
