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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->enum('method', ["cash", "transfer", "card(stripe)", "card(paypal)", "ideal", "giropay", "sofort"]);
            $table->decimal('amount', $precision = 12, $scale = 2);
            $table->decimal('usd_amount', $precision = 12, $scale = 2);
            $table->decimal('fee', $precision = 12, $scale = 2)->default(0);
            $table->string("currency", 10);
            $table->string('country_code');
            $table->datetime('received_at');
            $table->unsignedBigInteger('deduction_ratio_id');
            $table->unsignedBigInteger('deduction_account_id');
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('donor_id');
            $table->unsignedBigInteger('purpose_id');
            $table->unsignedBigInteger('targetable_id')->nullable();
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->enum('locale', ["ar", "en", "fr", "de", "tr", "es"]);
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('donor_id')->references('id')->on('donors');
            $table->foreign('country_code')->references('code')->on('countries');
            $table->foreign('purpose_id')->references('id')->on('purposes');
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deduction_ratio_id')->references('id')->on('deduction_ratios');
            $table->foreign('deduction_account_id')->references('id')->on('accounts');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations');
    }
}
