<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonorResetPasswordRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donor_reset_password_requests', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->integer('code')->unique();
            $table->bigInteger('donor_id');
            $table->boolean('consumed')->default(0);
            $table->tinyInteger('attempts')->default(0);
            $table->dateTime('expires_at');
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
        Schema::dropIfExists('donor_reset_password_requests');
    }
}
