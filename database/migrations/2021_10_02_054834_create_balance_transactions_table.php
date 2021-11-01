<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_transactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('transactionable', "transactionable_type");
            $table->string('notes');
            $table->enum('type', ['manual_payment', 'manual_payment_reversal', 'e_payment', 'e_payment_reversal', 'e_payment_full_refund', 'e_payment_partial_refund', 'transfer', 'relocate']);
            $table->datetime('handled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balance_transactions');
    }
}
