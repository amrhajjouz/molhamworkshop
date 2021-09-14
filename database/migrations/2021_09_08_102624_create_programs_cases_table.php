<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs_cases', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('target_id')->index()->nullable();
            $table->string('beneficiary_name')->index();
            $table->integer('serial_number')->index()->default(0);
            $table->string('country_code' , 5)->index();
            $table->enum('status' , ['funded' , 'unfunded' , 'canceled','spent'])->index()->default('unfunded');
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
        Schema::dropIfExists('programs_cases');
    }
}
