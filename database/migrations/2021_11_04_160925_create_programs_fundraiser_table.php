<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsFundraiserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs_fundraisers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('target_id')->index()->nullable();
            $table->boolean('verified' )->index()->default(0);
            $table->bigInteger('donor_id')->index();
            $table->boolean('public_visibility')->index()->default(0);
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
        Schema::dropIfExists('programs_fundraiser');
    }
}
