<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string("notes")->nullable();
            $table->enum("type",["payment","voucher","payout","payment_request"]);
            $table->morphs('journalable');
            $table->unsignedBigInteger('related_to')->nullable();
            $table->foreign('related_to')->references('id')->on('journals');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journals');
    }
}
