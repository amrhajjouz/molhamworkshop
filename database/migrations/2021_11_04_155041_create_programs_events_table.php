<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs_events', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('target_id')->index()->nullable();
            $table->date('date')->index();
            $table->bigInteger('donor_id')->index();
            $table->boolean('verified' )->index()->default(0);
            $table->boolean('public_visibility')->index()->default(0);
            $table->boolean('implemented')->index()->default(0);
            $table->date('implementation_date')->index()->nullable();
            $table->text('youtube_video_url')->nullable();
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
        Schema::dropIfExists('programs_events');
    }
}
