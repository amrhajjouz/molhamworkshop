<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'first_name' => ['ar'=>'Developer User' , 'en'=>"Developer User"],
            //'section_id' => 1,
            'email' => "admin@admin.com",
            'password' => Hash::make('12345678'),
        ]);


        $this->call([
            CountrySeeder::class ,
            PlaceSeeder::class ,
            UserSectionSeeder::class ,
        ]);
    }
}
