<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Title;
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

        $this->call([
            SectionSeeder::class , 
            TitleSeeder::class ,
            RolesPermissionsSeeder::class ,
        ]);
    }
}
