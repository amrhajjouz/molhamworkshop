<?php

namespace Database\Seeders;

use App\Models\TeamOffice;
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

        $this->call([
            CountrySeeder::class ,
            PlaceSeeder::class ,
            UserSectionSeeder::class ,
            JobTitleSeeder::class ,
        ]);

        User::where('id',1)->update([
            'user_section_id' => 1,
        ]);

        $this->call([
            TeamOfficeSeeder::class ,
            UserSeeder::class ,
        ]);

    }
}
