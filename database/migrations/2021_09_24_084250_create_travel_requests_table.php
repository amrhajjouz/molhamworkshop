<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('travel_destination', ['syria', 'istanbul', 'gaziantep']);
            $table->enum('means_of_travel', ['car', 'train', 'plane']);
            $table->enum('residence', ['hotel', 'friend']);
            $table->string('total_food_allowance')->nullable();
            $table->string('total_subsistence_allowance')->nullable();
            $table->string('total_transportation_allowance')->nullable();
            $table->string('travel_compensation')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('travel_requests', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
