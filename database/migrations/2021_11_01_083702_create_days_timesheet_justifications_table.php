<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaysTimesheetJustificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('days_timesheet_justifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('days_timesheet_id')->constrained('days_timesheet');
            $table->float('working_hours')->nullable();
            $table->text('details')->nullable();
            $table->enum('status', ['pending', 'expired', 'needs_approval', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_details')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('days_timesheet_justifications');
    }
}
