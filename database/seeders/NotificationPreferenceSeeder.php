<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NotificationPreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notification_preferences')->insert(['name' => 'newsletter']);
        DB::table('notification_preferences')->insert(['name' => 'subsciptions_2_days_reminder']);
        DB::table('notification_preferences')->insert(['name' => 'subscriptions_1_week_reminder']);
        DB::table('notification_preferences')->insert(['name' => 'purposes_updates']);
        DB::table('notification_preferences')->insert(['name' => 'shared_links']);
    }
}
