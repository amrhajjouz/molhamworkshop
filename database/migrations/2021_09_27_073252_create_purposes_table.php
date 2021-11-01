<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurposesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purposes', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("title");
            $table->string("targetable_type");
            $table->unsignedBigInteger("section_id");
            $table->unsignedBigInteger("program_id");
            $table->unsignedBigInteger("targetable_id")->nullable();
            $table->unsignedBigInteger("account_id");
            $table->foreign('account_id')->references('id')->on('accounts');
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
        Schema::dropIfExists('purposes');
    }
}
