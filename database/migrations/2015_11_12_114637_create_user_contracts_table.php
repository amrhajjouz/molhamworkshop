<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_section_id')->constrained('user_sections')->cascadeOnDelete();
            $table->foreignId('supervisor_id')->constrained('users')->cascadeOnDelete();
            $table->enum('contract_type', ['indefinite', 'full_time', 'part_time', 'freelance', 'consultant_contracts', 'field_work', 'project_employee_contracts']);
            $table->date('contract_start_date');
            $table->date('contract_end_date');
            $table->foreignId('job_title_id')->constrained('job_titles')->cascadeOnDelete();
            $table->enum('workplace', ['remotely', 'physically']);
            $table->foreignId('office_id')->nullable()->constrained('team_offices')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('salary');
            $table->string('working_hours');
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
        Schema::table('user_contracts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
