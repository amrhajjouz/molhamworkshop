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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->enum('status',["processing","paid","expired","failed","reversal","refunded","partially_refunded"]);
            $table->enum('method', ["cash", "transfer", "card(stripe)", "paypal(paypal)", "ideal", "giropay", "sofort"]);
            $table->decimal('amount', $precision = 12, $scale = 2);
            $table->decimal('reversed_amount', $precision = 12, $scale = 2)->default(0);
            $table->decimal('fee', $precision = 12, $scale = 2)->default(0);
            $table->decimal('fx_rate', $precision = 12, $scale = 2)->default(0);
            $table->string("currency", 10);
            $table->text("notes")->nullable();
            $table->foreign('donor_id')->references('id')->on('donors');
            $table->datetime('received_at');
            $table->datetime('handled_at')->nullable();
            $table->enum('locale', ["ar", "en", "fr", "de", "tr", "es"]);
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('donor_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');
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
        Schema::dropIfExists('payments');
    }
}
