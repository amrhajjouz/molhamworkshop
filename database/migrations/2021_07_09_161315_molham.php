<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Molham extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        
        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contentable_type')->index();
            $table->bigInteger('contentable_id')->index();
            $table->string('locale')->index()->default('ar');
            $table->string('name')->index();
            $table->text('value');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('constants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('plaintext')->index()->default(0);
            $table->string('name')->unique();
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('contents');
        Schema::dropIfExists('constants');
    }
}
