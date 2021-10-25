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
            $table->enum("type", ["manual_payment", "auto_fee", "auto_fees_reversal", "e_payment","refund_losses_auto_journal", "manual_journal", "refund", "reversal", "voucher", "payout", "transfer", "relocate", "payment_request"]);
            $table->morphs('journalable')->nullable();
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
