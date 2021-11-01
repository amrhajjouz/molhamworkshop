<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Account;
class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {

            $table->id();
            $table->string("code", 20);
            $table->json("name");
            $table->json("description")->nullable();
            $table->string("country_code", 3)->default(Account::$countryCodeDefault);
            $table->string("currency", 3)->default(Account::$currencyDefault);
            $table->decimal('income', $precision = 12, $scale = 2)->default(0);
            $table->decimal('outcome', $precision = 12, $scale = 2)->default(0);
            $table->decimal('balance', $precision = 12, $scale = 2)->default(0);
            $table->unsignedBigInteger("branch_id");
            $table->unsignedBigInteger('default_deduction_ratio_id')->nullable();
            $table->timestamps();
            $table->foreign('default_deduction_ratio_id')->references('id')->on('deduction_ratios');
            $table->foreign('branch_id')->references('id')->on('account_branches');
            $table->foreign('country_code')->references('code')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
