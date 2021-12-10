<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_offices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('office_manager');
            $table->foreign('office_manager')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->enum('type', ['head_office', 'department', 'unit', 'sub_unit']);
            $table->unsignedBigInteger('place_id');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
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
        Schema::dropIfExists('team_offices');
    }
}
