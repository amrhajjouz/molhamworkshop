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
        DB::table('users')->insert([
            'name' => 'Developer User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
        ]);

        $mohamd =User::create([
            'name' => 'mohamd User',
            'email' => 'mohamd@admin.com',
            'password' => Hash::make('123123'),
            'super_admin' => 1,
        ]);


        $permissions = [
            ['name' => 'donors.add', 'description_ar' => 'إضافة متبرع' ,'description_en' => " Lorem, ipsum dolor."],
            ['name' => 'donors.update', 'description_ar' => 'تعديل متبرع' ,'description_en' => " Lorem, ipsum dolor.",],
            ['name' => 'donors.delete', 'description_ar' => 'حذف متبرع' ,'description_en' => " Lorem, ipsum dolor.",],
            ['name' => 'donors.listing' , 'description_ar'=>'قائمة المتبرعين', 'description_en' => " Lorem, ipsum dolor.",],
            ['name' => 'donors.*' , 'description_ar'=>' المتبرعين', 'description_en' => " Lorem, ipsum dolor.",],
            ['name' => 'site.*' , 'description_ar'=>'الموقع ', 'description_en' => " Lorem, ipsum dolor.",],
            ['name' => 'test.test' , 'description_ar'=>'تجريب ', 'description_en' => " Lorem, ipsum dolor.",],
        ];


        foreach ($permissions  as $permission) {
            $p = Permission::create($permission);
            $mohamd->givePermissionTo($p);
        }


        /////////////////////// Roles /////////////////////////

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

    }
}
