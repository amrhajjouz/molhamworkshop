<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_donations', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->enum('payment_method', ["cash", "transfer", "card(stripe)", "paypal(paypal)", "ideal", "giropay", "sofort"]);
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('payment_transaction_id');
            $table->unsignedBigInteger('donor_id');
            $table->unsignedBigInteger('country_id');
            $table->enum('locale', ["ar", "en", "fr", "de", "tr", "es"]);
            $table->decimal('amount', $precision = 12, $scale = 2);
            $table->decimal('fee', $precision = 12, $scale = 2)->default(0);
            $table->string("currency", 10);
            $table->datetime('received_at');
            $table->foreign('payment_id')->references('id')->on('p_payments');
            $table->foreign('payment_transaction_id')->references('id')->on('p_payment_transactions');
            $table->foreign('donor_id')->references('id')->on('donors');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_donations');
    }
}
