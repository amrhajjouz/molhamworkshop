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
            $table->enum('contract_type', ['full_time', 'part_time', 'volunteer']);
            $table->date('contract_start_date')->nullable();
            $table->string('contract_period')->nullable();
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
