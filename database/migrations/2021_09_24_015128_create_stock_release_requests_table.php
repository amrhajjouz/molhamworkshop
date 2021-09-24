<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockReleaseRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_release_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_card_id')->constrained();
            $table->date('releasing_date');
            $table->foreignId('receiver_id');
            $table->foreignId('warehouse_keeper_id');
            $table->integer('quantity');
            $table->string('destination', 50);
            $table->text('notes');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->dateTime('released_at');
            $table->dateTime('received_at');
            $table->enum('status', ['pending', 'verified', 'rejected']);
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
        Schema::dropIfExists('stock_release_requests');
    }
}
