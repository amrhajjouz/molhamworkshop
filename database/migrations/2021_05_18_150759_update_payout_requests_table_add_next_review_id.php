<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePayoutRequestsTableAddNextReviewId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p_payout_requests', function($table) {
            $table->unsignedBigInteger('next_review_id')->nullable();
            $table->foreign('next_review_id')->references('id')->on('p_payout_request_reviews');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
