<?php

use App\Shared\TransactionHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_transactions', function (Blueprint $table) {
            $table->id();
            $table->enum("type", TransactionHelper::TypeList());
            $table->string("currency", 10);
            $table->decimal('amount', $precision = 12, $scale = 2);
            $table->decimal('usd_rate', $precision = 12, $scale = 2);
            $table->text("notes")->nullable();
            $table->unsignedBigInteger('related_to')->nullable();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
             $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('account_id')->references('id')->on('r_accounts');
            $table->foreign('related_to')->references('id')->on('r_transactions');
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_transactions');
    }
}
