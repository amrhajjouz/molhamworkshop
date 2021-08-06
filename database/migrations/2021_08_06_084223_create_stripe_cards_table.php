<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_cards', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_payment_method_id' , 50)->index();
            $table->string('fingerprint' , 50)->unique();
            $table->string('brand' , 20)->index();
            $table->integer('last4_digits')->index();
            $table->integer('expiry_month')->index();
            $table->integer('expiry_year')->index();
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
        Schema::dropIfExists('stripe_cards');
    }
}
