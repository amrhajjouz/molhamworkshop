<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsSponsorshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs_sponsorships', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('target_id')->index()->nullable();
            $table->string('beneficiary_name')->index();
            $table->date('beneficiary_birthdate')->index();
            $table->string('country_code')->index();
            $table->boolean('active')->index()->default(0);
            $table->boolean('sponsored')->index()->default(0);
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
        Schema::dropIfExists('programs_sponsorships');
    }
}
