<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('event_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("eventable_id")->index();
            $table->string("eventable_type")->index();
            $table->integer("event_id")->index();
            $table->integer("activity_id")->index()->nullable();
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
        Schema::dropIfExists('event_logs');
    }
}
