<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_id');
            $table->decimal('debit', $precision = 12, $scale = 2);
            $table->decimal('credit', $precision = 12, $scale = 2);
            $table->string("currency", 10);
            $table->decimal('fx_rate', $precision = 12, $scale = 2)->default(0);
            $table->enum('method', ["cash", "transfer", "card(stripe)", "paypal(paypal)", "ideal", "giropay", "sofort"]);
            $table->unsignedBigInteger("account_id");
            $table->unsignedBigInteger('section_id')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();;
            $table->unsignedBigInteger('related_to')->nullable();;
            $table->timestamps();
            $table->foreign('related_to')->references('id')->on('transactions');
            $table->foreign('journal_id')->references('id')->on('journals');
            //todo: add the missing foreign-keys
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
