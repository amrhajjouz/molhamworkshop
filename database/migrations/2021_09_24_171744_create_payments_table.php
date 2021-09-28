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
            $table->string('reference'); //todo: check with amr the name here again , we should distinguish between the auto generated and the manual payment
            $table->enum('status',["processing","paid","expired","failed"]);
            $table->enum('method', ["cash", "transfer", "card(stripe)", "paypal(paypal)", "ideal", "giropay", "sofort"]);
            $table->decimal('amount', $precision = 12, $scale = 2);
            $table->decimal('fee', $precision = 12, $scale = 2)->default(0);
            $table->decimal('fx_rate', $precision = 12, $scale = 2)->default(0);
            $table->string("currency", 10);
            $table->text("notes")->nullable();
            $table->foreign('donor_id')->references('id')->on('donors');
            $table->datetime('received_at');
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('donor_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
