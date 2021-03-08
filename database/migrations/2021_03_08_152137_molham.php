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
        //

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->timestamps();
        });

        Schema::create('sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->timestamps();
        });

        Schema::create('targets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('refrence')->unique();
            $table->string('model_type')->index();
            $table->bigInteger('model_id')->index();
            $table->bigInteger('section_id')->index();
            $table->bigInteger('category_id')->index();
            $table->integer('required')->index()->default(0);
            $table->integer('received')->index()->default(0);
            $table->integer('left')->index()->default(0);
            $table->integer('left_to_complete')->index()->default(0);
            $table->integer('spent')->index()->default(0);
            $table->integer('beneficiaries_count')->index()->default(0);
            $table->boolean('archived')->index()->default(0);
            $table->boolean('documented')->index()->default(0);
            $table->boolean('hidden')->index()->default(0);
            $table->boolean('posted')->index()->default(0);
            $table->timestamps();
        });


        Schema::create('campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->boolean('funded')->index()->default(0);
            $table->timestamps();
        });

        Schema::create('cases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('target_id')->index()->nullable();
            $table->bigInteger('country_id')->index();
            $table->string('beneficiary_name')->index();
            $table->integer('serial_number')->index()->default(0);
            $table->boolean('funded')->index()->default(0);
            $table->boolean('cancelled')->index()->default(0);
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
        Schema::dropIfExists('countries');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('target');
        Schema::dropIfExists('cases');
        Schema::dropIfExists('campaigns');
    }
}
