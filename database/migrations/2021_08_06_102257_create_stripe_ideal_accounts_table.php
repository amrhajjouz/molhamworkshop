<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeIdealAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_ideal_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_payment_method_id' , 50)->index();
            $table->string('owner_name' , 50)->index();
            $table->string('bank_name' , 50)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stripe_ideal_accounts');
    }
}
