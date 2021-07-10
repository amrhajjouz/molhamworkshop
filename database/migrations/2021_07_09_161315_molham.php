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

        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->string("name", 30);
            $table->string("email", 155);
            $table->text("password");
            $table->string("phone", 20)->nullable();
            $table->string("swish_number", 20)->nullable();;
            $table->string("whatsapp_number", 20)->nullable();
            $table->boolean("subscribed_to_newsletter")->default(false);
            $table->boolean("verified")->default(false);
            $table->boolean("blocked")->default(false);
            $table->boolean("closed")->default(false);
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

        Schema::create('shortcuts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path')->index();
            $table->timestamps();
        });

        Schema::create('shortcut_keys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shortcut_id');
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url')->unique();
            $table->timestamps();
        });

        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url')->unique();
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
        //
        Schema::dropIfExists('donor');
        Schema::dropIfExists('users');
        Schema::dropIfExists('contents');
        Schema::dropIfExists('constants');
        Schema::dropIfExists('shortcuts');
        Schema::dropIfExists('shortcut_keys');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('blogs');
    }
}
