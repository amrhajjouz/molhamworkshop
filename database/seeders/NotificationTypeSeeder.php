<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NotificationTemplate;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $notificationsTypes = [
            ['name' => 'view_user', 'body' => ['ar' => 'تم مشاهد المستخدم  {user_id} , من قبل المستخدم {viewer_name}',  'en' => "user retrived {date}"], "path" => url('/users/{id}/{user_lang}')],
        ];

        foreach ($notificationsTypes  as $notification) {
            NotificationTemplate::create($notification);
        }
    }
}
