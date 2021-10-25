<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_payout_requests', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 12, $scale = 2);
            $table->string("currency", 10);
            $table->string('purpose_type');
            $table->string('purpose_id')->nullable();
            $table->text("details")->nullable();
            $table->enum('status',["pending","approved","rejected"]);
            $table->timestamps();
            $table->datetime('rejected_at')->nullable();
            $table->unsignedBigInteger('assignee_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('rejected_by')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('assignee_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_payout_requests');
    }
}
