<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type',["donation","transfer","payout"]);
            $table->string('purpose_type');
            $table->string('purpose_id')->nullable();
            $table->decimal('amount', $precision = 12, $scale = 2);
            $table->text("notes")->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('related_to')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('related_to')->references('id')->on('p_payment_transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_payment_transactions');
    }
}
