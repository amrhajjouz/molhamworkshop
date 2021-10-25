<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutRequestReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_payout_request_reviews', function (Blueprint $table) {
            $table->id();
            $table->enum('status',["pending","approved","rejected"]);
            $table->string("notes")->nullable();
            $table->string("required_role");
            $table->integer("priority");
            $table->timestamps();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->foreign('request_id')->references('id')->on('p_payout_requests');
            $table->foreign('reviewed_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('p_payout_request_reviews');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
