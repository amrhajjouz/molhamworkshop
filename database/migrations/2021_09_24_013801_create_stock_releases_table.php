<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_releases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_card_id')->constrained();
            $table->integer('quantity');
            $table->date('release_date');
            $table->string('destination',50);
            $table->foreignId('receiver_id');
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
        Schema::dropIfExists('stock_releases');
    }
}
