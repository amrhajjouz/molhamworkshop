<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->default(Hash::make('12345678'));
            $table->enum('job_type', ['ceo', 'manager', 'coordinator', 'senior_officer', 'officer', 'assistant', 'volunteer']);
            $table->enum('contract_type', ['full_time', 'part_time']);
            $table->enum('section', ['finance', 'programmes', 'hr']);
            $table->enum('degree', ['1', '2', '3']);
            $table->enum('office', ['turkey', 'jordan', 'syria', 'Lebanon']);
            $table->enum('job_descriptions', ['financial_coordinator', 'assistant']);
            $table->date('contract_starting_date')->nullable();
            $table->enum('locale' , ['ar' , 'en'])->default('ar');
            $table->text('bio')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
