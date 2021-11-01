<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountIdToDeductionRatiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deduction_ratios', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deduction_ratios', function (Blueprint $table) {
            $table->dropForeign('deduction_ratios_account_id_foreign');
            $table->dropColumn(['account_id']);
        });
    }
}
