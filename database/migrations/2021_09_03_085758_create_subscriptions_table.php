<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('reference' , 17)->unique();
            $table->bigInteger('donor_id');
            $table->bigInteger('payment_method_id')->nullable();
            $table->enum('frequency' , ['month' , 'week' , 'day'])->default('month');
            $table->enum("locale" , ['ar' , 'en' , 'fr' , 'de'])->default("ar");
            $table->float('total_amount', 20, 2)->index()->default(0);
            $table->integer('billing_day')->default(1);
            $table->enum("status" , ['pending' , 'expired' , 'active' , 'canceled' , 'suspended' , 'ended'])->default("pending");
            $table->integer('total_payments')->default(1);
            $table->integer('paid_payments')->default(0);
            $table->integer('failed_payments')->default(0);
            $table->integer('failed_billing_attempts')->default(0);
            $table->dateTime('first_billing_time')->nullable();
            $table->dateTime('next_billing_time')->nullable();
            $table->dateTime('last_billing_time')->nullable();
            $table->dateTime('final_billing_time')->nullable();
            $table->boolean('has_handling_payment')->default(0);
            $table->dateTime('started_at')->nullable();
            $table->dateTime('suspended_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->enum('cancellation_reason' , ["requested_by_subscriber" , "canceled_by_subscriber" , "suspended_subscription" , "ended_purpose"])->nullable();
            $table->bigInteger("renewal_for")->nullable();
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
        Schema::dropIfExists('subscriptions');
    }
}
