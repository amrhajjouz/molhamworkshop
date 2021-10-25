<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->enum('status',["processing","paid","expired","failed"]);
            $table->unsignedBigInteger('receiver_transaction_id');
            $table->unsignedBigInteger('donor_id');
            $table->decimal('amount', $precision = 12, $scale = 2);
            $table->decimal('fee', $precision = 12, $scale = 2)->default(0);
            $table->string("currency", 10);
            $table->text("notes")->nullable();
            $table->foreign('receiver_transaction_id')->references('id')->on('r_transactions');
            $table->foreign('donor_id')->references('id')->on('donors');
            $table->datetime('received_at');
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('p_payments');
    }
}
