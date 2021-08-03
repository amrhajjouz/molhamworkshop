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
       
        DB::table('users')->insert([
            'name' => 'Mohammed Ghannoum',
            'email' => 'mohamd@admin.com',
            'password' => Hash::make('123123'),
        ]);
        
        DB::table('donors')->insert([
            'name' => 'Mohammed Ghannoum',
            'email' => 'mohamd@admin.com',
            'password' => Hash::make('123123'),
        ]);


        
        DB::table('notification_preferences')->insert(['name' => 'newsletter']);
        DB::table('notification_preferences')->insert(['name' => 'subsciptions_2_days_reminder']);
        DB::table('notification_preferences')->insert(['name' => 'subscriptions_1_week_reminder']);
        DB::table('notification_preferences')->insert(['name' => 'purposes_updates']);
        DB::table('notification_preferences')->insert(['name' => 'shared_links']);
    }
}
