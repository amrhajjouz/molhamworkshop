<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            'name' => 'Developer User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
        ]);

        $this->call([
            UserSeeder::class,
            NotificationPrefernceSeeder::class,
            DonorSeeder::class,
            CountrySeeder::class,
            CategorySeeder::class,
            PlaceSeeder::class,
            ProjectSeeder::class,
            SmallProjectSeeder::class,
            SponsorshipSeeder::class,
            ScholarshipSeeder::class,
            EventSeeder::class,
            FundraiserSeeder::class,
            CampaignSeeder::class,
            CasesSeeder::class,
        ]);
    }
}
