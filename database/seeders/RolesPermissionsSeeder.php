<?php

namespace Database\Seeders;

use App\Models\{User, Role, Permission};
use Illuminate\Database\Seeder;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mohamd = User::where('email', 'mohamd@admin.com')->firstOrFail();
        $amro = User::where('email', 'admin@admin.com')->firstOrFail();
        $super_admin = Role::create(['name' => 'super-admin', 'title' => ['ar' =>  'سوبر ادمن', 'en' =>  "Super Admin",], 'guard_name' => 'web',]);
        Role::create(['name' => 'manager', 'title' => ['ar' =>  'مدير', 'en' =>  " Lorem, ipsum dolor.",], 'guard_name' => 'web',]);
        Role::create(['name' => 'admin', 'title' => ['ar' =>  'مشرف عام', 'en' =>  " Lorem, ipsum dolor.",], 'guard_name' => 'web',]);
        Role::create(['name' => 'moderator', 'title' => ['ar' =>  'مدير قسم', 'en' =>  " Lorem, ipsum dolor.",], 'guard_name' => 'web',]);
        Role::create(['name' => 'user', 'title' => ['ar' =>  'مستخدم', 'en' =>  " Lorem, ipsum dolor.",], 'guard_name' => 'web',]);
        $permissions = [
            ///////////////////// donors /////////////////////
            ['name' => '*', "title" => ['ar' => '*', 'en' => "*"]],
            ['name' => 'donors.create', "title" => ['ar' => 'اضافة المتبرعين', 'en' => "Create Donors"]],
            ['name' => 'donors.update', "title" => ['ar' => 'تعديل المتبرعين', 'en' => "Update Donors"],],
            ['name' => 'donors.view', "title" => ['ar' => 'عرض المتبرعين', 'en' => "View Donors"],],
            ['name' => 'donors.*', "title" => ['ar' => 'ادارة المتبرعين', 'en' => "Manage Donors"],],
            ///////////////////// sections /////////////////////
            ['name' => 'sections.create', "title" => ['ar' => 'اضافة الأقسام', 'en' => "Create Sections"]],
            ['name' => 'sections.update', "title" => ['ar' => 'تعديل الأقسام', 'en' => "Update Sections"],],
            ['name' => 'sections.view', "title" => ['ar' => 'عرض الأقسام', 'en' => "View Sections"],],
            ['name' => 'sections.*', "title" => ['ar' => 'ادارة الأقسام', 'en' => "Manage Sections"],],
        ];
        foreach ($permissions  as $permission) {
            $p = Permission::create($permission);
            if ($p->name == "*") {
                $super_admin->givePermissionTo($p->name);
            } else {
                $mohamd->givePermissionTo($p);
                $amro->givePermissionTo($p);
            }
        }
        $mohamd->assignRole('super-admin');
        $amro->assignRole('super-admin');
    }
}
