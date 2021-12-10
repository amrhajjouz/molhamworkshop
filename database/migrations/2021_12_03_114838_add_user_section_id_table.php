<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AddUserSectionIDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('user_section_id')->nullable()->after('id')->constrained('user_sections')->cascadeOnDelete();
        });
        \App\Models\User::create([
            'name' => 'admin',
            'first_name' => ['ar'=>'Developer' , 'en'=>"Developer"],
            'last_name' => ['ar'=>'User' , 'en'=>"User"],
            'email' => "admin@admin.com",
            'password' => Hash::make('12345678'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('user_section_id');
        });
    }
}
