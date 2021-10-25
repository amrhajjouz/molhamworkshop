<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_accounts', function (Blueprint $table) {
            $table->id();
            $table->string("name", 30);
            $table->string("currency", "6");
            $table->enum("status", ["active", "inactive"])->default("active");
            $table->decimal('initial_balance', $precision = 12, $scale = 2)->default(0);
            $table->decimal('income', $precision = 12, $scale = 2)->default(0);
            $table->decimal('outcome', $precision = 12, $scale = 2)->default(0);
            $table->decimal('left', $precision = 12, $scale = 2)->default(0);
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('receiver_id')->references('id')->on('r_receivers');
            $table->foreign('type_id')->references('id')->on('r_accounts_types');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_accounts');
    }
}
