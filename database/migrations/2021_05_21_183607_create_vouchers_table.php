<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_payout_vouchers', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 12, $scale = 2);
            $table->string("currency", 10);
            $table->string('purpose_type');
            $table->string('purpose_id')->nullable();
            $table->text("details")->nullable();
            $table->timestamps();
            $table->datetime('spent_at')->nullable();
            $table->datetime('delivered_at')->nullable();
            $table->unsignedBigInteger('payout_request_id')->unique();
            $table->unsignedBigInteger('assignee_id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('agreement_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('payout_request_id')->references('id')->on('p_payout_request_reviews');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('account_id')->references('id')->on('countries');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('assignee_id')->references('id')->on('users');
            $table->foreign('agreement_id')->references('id')->on('p_agreements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_payout_vouchers');
    }
}
