<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeSofortAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_sofort_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_payment_method_id' , 50)->index();
            $table->string('owner_name' , 20)->index();
            $table->string('country_code' , 2)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stripe_sofort_accounts');
    }
}
