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
            'name' => 'mohamd User',
            'email' => 'mohamd@admin.com',
            'password' => Hash::make('123123'),
        ]);
       

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

       /////////////////////// Permissions /////////////////////////
        DB::table('permissions')->insert([
            'name' => 'create donor',
            'ar_name' => 'إضافة متبرع',
            'guard_name' => 'web',
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit donor',
            'ar_name' => 'تعديل متبرع',
            'guard_name' => 'web',
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete donor',
            'ar_name' => 'حذف متبرع',
            'guard_name' => 'web',
        ]);
    }
}
