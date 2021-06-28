<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
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
        $amro =User::create([
            'name' => 'Developer User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
        ]);
        $mohamd =User::create([
            'name' => 'mohamd User',
            'email' => 'mohamd@admin.com',
            'password' => Hash::make('123123'),
        ]);
        /////////////////////// Roles /////////////////////////
       $super_admin = Role::create([
            'name' => 'super-admin',
            'description_ar' => 'سوبر ادمن',
            'description_en' => "Super Admin",
            'guard_name' => 'web',
        ]);

        DB::table('roles')->insert([
            'name' => 'manager',
            'description_ar' => 'مدير',
            'description_en' =>" Lorem, ipsum dolor.",
            'guard_name' => 'web',
        ]);
        DB::table('roles')->insert([
            'name' => 'admin',
            'description_ar' => 'مشرف عام',
            'guard_name' => 'web',
        ]);

        DB::table('roles')->insert([
            'name' => 'moderator',
            'description_ar' => 'مدير قسم ',
            'description_en' => " Lorem, ipsum dolor.",
            'guard_name' => 'web',
        ]);
        DB::table('roles')->insert([
            'name' => 'user',
            'description_ar' => 'مستخدم ',
            'description_en' => " Lorem, ipsum dolor.",
            'guard_name' => 'web',
        ]);

        $permissions = [
            ['name' => '*', 'description_ar' => '*', 'description_en' => "*"],
            ['name' => 'donors.create', 'description_ar' => 'اضافة المتبرعين', 'description_en' => "Create Donors"],
            ['name' => 'donors.update', 'description_ar' => 'تعديل المتبرعين', 'description_en' => "Update Donors",],
            ['name' => 'donors.view', 'description_ar' => 'عرض المتبرعين', 'description_en' => "View Donors",],
            ['name' => 'donors.*', 'description_ar' => 'ادارة المتبرعين', 'description_en' => "Manage Donors",],

            ['name' => 'activities.create', 'description_ar' => 'اضافة النشاطات', 'description_en' => "Create activities"],
            ['name' => 'activities.update', 'description_ar' => 'تعديل النشاطات', 'description_en' => "Update activities",],
            ['name' => 'activities.view', 'description_ar' => 'عرض النشاطات', 'description_en' => "View activities",],
            ['name' => 'activities.*', 'description_ar' => 'ادارة النشاطات', 'description_en' => "Manage activities",],
        ];

        foreach ($permissions  as $permission) {
            $p = Permission::create($permission);
            if($p->name == "*"){
                $super_admin->givePermissionTo($p->name);
            }else{
                $mohamd->givePermissionTo($p);
                $amro->givePermissionTo($p);
            }
        }

        $mohamd->assignRole('super-admin');
        $amro->assignRole('super-admin');



        ////////activity
        $activities = [
            ['name' => 'create_donor', 'body_ar' => 'تم إضافة متبرع', 'body_en' => "Donors created"],
            ['name' => 'update_donor', 'body_ar' => 'تم تعديل متبرع', 'body_en' => "Donor Updated",],
            ['name' => 'view_donor', 'body_ar' => 'تم مشاهدة متبرع', 'body_en' => "Donors retrieved",],
            ['name' => 'list_donors', 'body_ar' => 'تم استعراض المتبرعين ', 'body_en' => "Donors listed",],
           
            ['name' => 'create_user', 'body_ar' => 'تم إضافة مستخدم', 'body_en' => "users created"],
            ['name' => 'update_user', 'body_ar' => 'تم تعديل مستخدم', 'body_en' => "user Updated",],
            ['name' => 'view_user', 'body_ar' => 'تم مشاعدة مستخدم', 'body_en' => "users retrieved",],
            ['name' => 'list_users', 'body_ar' => 'تم استعراض المستخدمين ', 'body_en' => "users listed",],
        ];


        foreach($activities  as $activity){
            DB::table('activities')->insert($activity);
         
        }
    }
}
