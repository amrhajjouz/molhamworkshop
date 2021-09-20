<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->enum("type", ["category", "title", "main"]);
            $table->string("code", 20);
            $table->json("name");
            $table->decimal('balance', $precision = 12, $scale = 2)->default(0);
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('account_branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_branches');
    }
}
