<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_agreements', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("currency", 10);
            $table->decimal('amount', 12, $scale = 2);
            $table->decimal('admin_costs_percentage', 12, $scale = 2);
            $table->string("details");
            $table->enum("status",["pending","completed","canceled"]);
            $table->unsignedBigInteger('canceled_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->dateTime('starting_date');
            $table->dateTime('ending_date');
            $table->dateTime('canceled_at')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('p_agreements');
    }
}
