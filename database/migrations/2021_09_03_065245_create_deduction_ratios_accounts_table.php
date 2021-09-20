<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeductionRatiosAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deduction_ratios_accounts', function (Blueprint $table) {
            $table->id();
            $table->decimal('ratio', $precision = 12, $scale = 2);
            $table->timestamps();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('deduction_ratio_id');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('deduction_ratio_id')->references('id')->on('deduction_ratios');
            $table->unique(array('deduction_ratio_id', 'account_id'));
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deduction_ratios_accounts');
    }
}
