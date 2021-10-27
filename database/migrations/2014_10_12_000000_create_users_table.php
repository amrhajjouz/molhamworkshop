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
            //info data
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('email')->unique();
            $table->string('password')->default(Hash::make('12345678'));
            //members data
            $table->enum('career_level', ['ceo', 'manager', 'coordinator', 'senior_officer', 'officer', 'assistant', 'volunteer']);
            $table->enum('section', ['finance', 'programmes', 'hr']);
            $table->enum('office', ['turkey', 'jordan', 'syria', 'Lebanon']);
            $table->enum('job_title', ['administrative', 'department_assistant']);
            $table->enum('degree', ['1', '2', '3']);
            $table->enum('contract_type', ['full_time', 'part_time']);
            $table->date('contract_starting_date')->nullable();
            $table->string('direct_manager')->nullable();
            $table->enum('job_descriptions', ['financial_coordinator', 'assistant']);
            $table->string('main_tasks')->nullable();
            $table->string('additional_tasks')->nullable();
            //profile/job_data
            $table->string('job_number')->nullable();
            //profile/national_data
            $table->string('nationality')->nullable();
            $table->string('document_type')->nullable();
            //profile/housing_data
            $table->string('country')->nullable();
            $table->string('governorate')->nullable();
            $table->string('city')->nullable();
            $table->string('detailed_address')->nullable();
            //profile/education_record
            $table->string('education_level')->nullable();
            $table->date('graduation_year')->nullable();
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
