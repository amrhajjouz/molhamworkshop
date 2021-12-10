<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            //$table->foreignId('user_section_id')->default(1)->constrained('user_sections')->cascadeOnDelete();
            $table->json('first_name')->nullable();
            $table->json('last_name')->nullable();
            $table->json('father_name')->nullable();
            $table->json('mother_name')->nullable();
            $table->string('email')->unique();
            $table->enum('locale' , ['ar' , 'en'])->default('ar');
            $table->text('bio')->nullable();
            $table->string('nationality_code')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date')->nullable();
            $table->string('password')->default(Hash::make('12345678'));
            $table->string('education_level')->nullable();
            $table->string('education_section')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('reference_person_name')->nullable();
            $table->string('reference_person_phone')->nullable();
            $table->string('reference_person_relation_type')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('physical_disability')->nullable();
            $table->string('communicable_diseases')->nullable();
            //profile/residence data
            $table->string('current_residence')->nullable();
            $table->enum('residence_type', ['identification', 'residence']);
            $table->string('residence_file')->nullable();
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
