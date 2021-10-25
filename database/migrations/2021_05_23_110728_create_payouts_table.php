<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_payouts', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 12, $scale = 2);
            $table->string("currency", 10);
            $table->string("reference");
            $table->timestamps();
            $table->unsignedBigInteger('payout_voucher_id')->unique();
            $table->unsignedBigInteger('receiver_transaction_id');
            $table->unsignedBigInteger('payment_transaction_id');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->datetime('deleted_at')->nullable();
            $table->foreign('payout_voucher_id')->references('id')->on('p_payout_request_reviews');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('payment_transaction_id')->references('id')->on('p_payment_transactions');
            $table->foreign('receiver_transaction_id')->references('id')->on('r_transactions');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_payouts');
    }
}
