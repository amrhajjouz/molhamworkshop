<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AvtivitiesLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    Schema::create('activiy_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("loggable_id")->index();
            $table->string("loggable_type")->index();
            $table->integer("activity_id")->index();
            $table->string("actor_type")->index();
            $table->bigInteger("actor_id")->index();
            $table->json("metadata")->nullable();
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
        Schema::dropIfExists('activiy_logs');
    }
}
