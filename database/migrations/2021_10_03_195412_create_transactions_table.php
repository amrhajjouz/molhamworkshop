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
            $table->unsignedBigInteger('	journal_id');
            $table->decimal('amount', $precision = 12, $scale = 2);
            $table->string("currency", 10);
            $table->decimal('fx_rate', $precision = 12, $scale = 2)->default(0);
            $table->enum('method', ["cash", "transfer", "card(stripe)", "paypal(paypal)", "ideal", "giropay", "sofort"]);
            $table->unsignedBigInteger("account_id");
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('related_to');
            $table->timestamps();//todo: add forign-keys
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
