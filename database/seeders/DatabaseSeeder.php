<?php

namespace Database\Seeders;

use App\Models\Permission;
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
            'super_admin' => 1,
        ]);
        $mohamd =User::create([
            'name' => 'mohamd User',
            'email' => 'mohamd@admin.com',
            'password' => Hash::make('123123'),
            'super_admin' => 1,
        ]);




        /////////////////////// Roles /////////////////////////

        DB::table('roles')->insert([
            'name' => 'super admin',
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
            ['name' => 'donors.create', 'description_ar' => 'اضافة المتبرعين', 'description_en' => "Create Donors"],
            ['name' => 'donors.update', 'description_ar' => 'تعديل المتبرعين', 'description_en' => "Update Donors",],
            ['name' => 'donors.view', 'description_ar' => 'عرض المتبرعين', 'description_en' => "View Donors",],
            ['name' => 'donors.*', 'description_ar' => 'ادارة المتبرعين', 'description_en' => "Manage Donors",],

            ['name' => 'writer.*', 'description_ar' => ' المتبرعين', 'description_en' => " Lorem, ipsum dolor.",],
            ['name' => 'site.*', 'description_ar' => 'الموقع ', 'description_en' => " Lorem, ipsum dolor.",],
            ['name' => 'test.test', 'description_ar' => 'تجريب ', 'description_en' => " Lorem, ipsum dolor.",],
        ];





        foreach ($permissions  as $permission) {
            $p = Permission::create($permission);
            $mohamd->givePermissionTo($p);
            $amro->givePermissionTo($p);
        }

        $mohamd->assignRole('super admin');
        $amro->assignRole('super admin');

    }
}
