<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_checks', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['in', 'out']);
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status', ['checked', 'rejected'])->nullable();
            $table->foreignId('office_id')->constrained('offices');
            $table->boolean('off_day')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->foreignId('rejected_by')->nullable()->constrained('users');
            $table->text('rejection_details')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
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
        Schema::dropIfExists('users_checks');
    }
}
