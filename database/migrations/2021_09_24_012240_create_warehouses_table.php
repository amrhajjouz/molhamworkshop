<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30);
            $table->foreignId('place_id');
            $table->float('length', 20, 2);
            $table->float('width', 20, 2);
            $table->float('height', 20, 2);
            $table->float('latitude', 20, 2);
            $table->float('longitude', 20, 2);
            $table->date('contract_starting_date');
            $table->date('contract_ending_date');
            $table->foreignId('keeper_id');
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
        Schema::dropIfExists('warehouses');
    }
}
