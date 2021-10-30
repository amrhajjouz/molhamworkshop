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
            $table->enum("type", ['payment', 'payment_reversal', 'transfer', 'auto_fee', 'auto_fee_reversal', 'fee_loss', 'payout', 'payout_reversal']);
            $table->unsignedBigInteger('balance_transaction_id');
            $table->foreign('balance_transaction_id')->references('id')->on('balance_transactions');
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
        Schema::dropIfExists('journals');
    }
}
