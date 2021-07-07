<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\NotificationType;

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


        $notificationsTypes = [
            ['name' => 'view_user', 'body_ar' => 'تم مشاهد المستخدم  {{user_id}} , من قبل المستخدم {{viewer_name}}', 'body_en' => "user retrived {{date}}" , "path"=>url('/users/{{id}}/{{user_lang}}') ],
        ];

        foreach ($notificationsTypes  as $notification) {NotificationType::create($notification);}
     
    }
}