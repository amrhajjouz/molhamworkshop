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
            CountrySeeder::class,
        ]);

          \App\Models\User::create([
            'name' => 'admin',
            'first_name' => ['ar'=>'Developer' , 'en'=>"Developer"],
            'last_name' => ['ar'=>'User' , 'en'=>"User"],
            'email' => "admin@admin.com",
            'password' => Hash::make('12345678'),
        ]);

        $this->call([
            PlaceSeeder::class ,
            UserSectionSeeder::class ,
            JobTitleSeeder::class ,
            LeaveTypeSeeder::class ,
        ]);

        /*User::where('id',1)->update([
            'user_section_id' => 1,
        ]);*/

        $this->call([
            TeamOfficeSeeder::class ,
            UserSeeder::class ,
        ]);

    }
}
