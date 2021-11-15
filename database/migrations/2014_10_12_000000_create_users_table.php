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
            $table->foreignId('section_id')->nullable()->constrained('user_sections')->cascadeOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained('user_contracts')->cascadeOnDelete();
            $table->json('first_name')->nullable();
            $table->json('last_name')->nullable();
            $table->json('father_name')->nullable();
            $table->json('mother_name')->nullable();
            $table->string('email')->unique();
            $table->enum('locale' , ['ar' , 'en'])->default('ar');
            $table->text('bio')->nullable();
            $table->string('nationality_code')->nullable();
            $table->text('image')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date')->nullable();
            $table->string('password')->default(Hash::make('12345678'));
            //members data || profile/job data
            //$table->enum('employment_level', ['ceo', 'manager', 'coordinator', 'senior_officer', 'officer', 'assistant', 'volunteer']);
            //$table->enum('employment_degree', ['1', '2', '3']);
            //profile/contact data
            //$table->string('phone')->nullable();
            //$table->string('whatsapp')->nullable();
            //$table->string('reference_person_name')->nullable();
            //$table->string('reference_person_phone')->nullable();
            //$table->string('reference_person_relation_type')->nullable();
            //$table->string('facebook')->nullable();
            //$table->string('instagram')->nullable();
            //profile/residence data
            //$table->string('place_of_birth')->nullable();
            //$table->string('document_type')->nullable();
            //$table->string('document_number')->nullable();
            //$table->date('document_issuance_date')->nullable();
            //$table->date('document_expiration_date')->nullable();
            //$table->string('current_residence')->nullable();
            //profile/experiences and skills
            //$table->string('previous_work')->nullable();
            //$table->string('employer')->nullable();
            //$table->string('country_worked_in')->nullable();
            //$table->string('job_title_worked_in')->nullable();
            //$table->string('start_date_worked_in')->nullable();
            //$table->string('end_date_worked_in')->nullable();
            //profile/additional data
            /*$table->string('blood_type')->nullable();
            $table->string('physical_disability')->nullable();
            $table->string('physical_disability_description')->nullable();
            $table->string('communicable_diseases')->nullable();
            $table->string('communicable_diseases_description')->nullable();*/
            //profile/education
            /*$table->string('education_level')->nullable();
            $table->string('education_section')->nullable();
            $table->string('educational_facility')->nullable();
            $table->string('educational_country')->nullable();
            $table->string('educational_language')->nullable();
            $table->string('educational_status')->nullable();
            $table->date('graduation_year')->nullable();
            $table->string('average')->nullable();
            $table->string('native_language')->nullable();
            $table->string('other_languages')->nullable();*/
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
