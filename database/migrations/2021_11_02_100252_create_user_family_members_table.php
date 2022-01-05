<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFamilyMembersTable extends Migration
{
    public function up()
    {
        Schema::create('user_family_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->enum('relative_relation', ['partner', 'child']);
            //$table->string('date_of_marriage')->nullable();
            //$table->string('date_of_birth')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('user_family_members', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
