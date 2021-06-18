<?php

namespace Database\Seeders;

use App\Models\Permission;
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
            'name' => 'mohamd User',
            'email' => 'mohamd@admin.com',
            'password' => Hash::make('123123'),
        ]);


        $permissions = [
            ['name' => 'create donor', 'ar_name' => 'إضافة متبرع'], ['name' => 'update donor', 'ar_name' => 'تعديل متبرع'], ['name' => 'delete donor', 'ar_name' => 'حذف متبرع']
            , ['name' => 'listing donors' , 'ar_name'=>'قائمة المتبرعين']
        ];


        foreach ($permissions  as $permission) {
            Permission::create($permission);
        }


        /////////////////////// Roles /////////////////////////

        DB::table('roles')->insert([
            'name' => 'super admin',
            'ar_name' => 'مدير',
            'guard_name' => 'web',
        ]);
        DB::table('roles')->insert([
            'name' => 'admin',
            'ar_name' => 'مشرف عام',
            'guard_name' => 'web',
        ]);

        DB::table('roles')->insert([
            'name' => 'moderator',
            'ar_name' => 'مدير قسم ',
            'guard_name' => 'web',
        ]);

    }
}
