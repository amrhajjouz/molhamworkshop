<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
              Schema::table('users', function (Blueprint $table) {
                        $table->foreignId('office_id')->nullable()->constrained('offices');
                        $table->string('timesheet_passcode')->nullable();
                        $table->foreignId('timesheet_device_id')->nullable()->constrained('timesheet_devices');
              });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
