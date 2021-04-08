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
            $table->string('created_for')->index();
            $table->timestamps();
        });

        Schema::create('targets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference')->unique();
            $table->string('purpose_type')->index();
            $table->bigInteger('purpose_id')->index();
            $table->bigInteger('section_id')->index()->nullable();
            $table->bigInteger('category_id')->index()->nullable();
            $table->integer('required')->index()->default(0);
            $table->integer('received')->index()->default(0);
            $table->integer('left')->index()->default(0);
            $table->integer('left_to_complete')->index()->default(0);
            $table->integer('spent')->index()->default(0);
            $table->integer('beneficiaries_count')->index()->default(0);
            $table->boolean('archived')->index()->default(0);
            $table->boolean('documented')->index()->default(0);
            $table->boolean('visible')->index()->default(1);
            $table->boolean('posted')->index()->default(0);
            $table->timestamps();
        });


        Schema::create('campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('target_id')->index()->nullable();
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
            // $table->boolean('funded')->index()->default(0);
            // $table->boolean('cancelled')->index()->default(0);
            $table->enum('status' , ['funded' , 'unfunded' , 'canceled','spent'])->index()->default('unfunded');
            $table->bigInteger('created_by')->nullable()->index();
            $table->timestamps();
        });
       
        Schema::create('sponsorships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('target_id')->index()->nullable();
            $table->bigInteger('country_id')->index();
            $table->string('beneficiary_name')->index();
            $table->string('beneficiary_birthdate')->index();
            $table->boolean('sponsored')->index()->default(0);
            $table->timestamps();
        });
     
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('target_id')->index()->nullable();
            $table->bigInteger('country_id')->index();
            $table->string('name')->index();
            $table->integer('semesters_count')->index()->default(1);
            $table->integer('current_semester')->index()->default(1);
            $table->integer('semesters_funded' )->index()->default(0);
            $table->integer('semesters_left' )->index()->default(0);
            $table->enum('status' , ['paused' , 'not_funded' , 'currently_funded' ,'fully_funded'])->index()->default('not_funded');

            $table->timestamps();
        });
       
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('target_id')->index()->nullable();
            $table->bigInteger('donor_id')->index();
            $table->date('date')->index();
            $table->boolean('verified' )->index()->default(0);
            $table->boolean('public_visibility')->index()->default(0);
            $table->boolean('implemented')->index()->default(0);
            $table->date('implementation_date')->index()->nullable();
            $table->string('youtube_video_url')->index()->nullable();

            $table->timestamps();
        });
     
        Schema::create('fundraisers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('target_id')->index()->nullable();
            $table->bigInteger('donor_id')->index();
            $table->boolean('verified' )->index()->default(0);
            $table->boolean('public_visibility')->index()->default(0);

            $table->timestamps();
        });
     
        Schema::create('places', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->index()->nullable();
            $table->bigInteger('country_id')->index()->nullable();
            $table->string('name')->index()->nullable();
            $table->enum('type' ,['province' , 'city' ,'village' , 'district' ] )->index()->default('city');

            $table->timestamps();
        });
       
        Schema::create('placeables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('place_id')->index();
            $table->string('placeable_type')->index();
            $table->bigInteger('placeable_id')->index();
            $table->timestamps();
        });
       
        Schema::create('sponsors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('donor_id')->index();
            $table->string('purpose_type')->index();
            $table->bigInteger('purpose_id')->index();
            $table->integer('percentage')->index()->default(0);
            $table->boolean('active')->index()->default(0);
            $table->timestamps();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('adminable_type')->index();
            $table->bigInteger('adminable_id')->index();
            $table->bigInteger('user_id')->index();
            $table->boolean('notified')->default(0);
            // $table->enum('role', ['supervisor', 'field_officer', 'media_officer', 'data_entry'])->index();
            $table->softDeletes();

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
            $table->timestamps();
        });
       
        Schema::create('faqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id');
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
        Schema::dropIfExists('sponsor_ships');
        Schema::dropIfExists('students');
        Schema::dropIfExists('events');
        Schema::dropIfExists('fundraisers');
        Schema::dropIfExists('places');
        Schema::dropIfExists('placeables');
        Schema::dropIfExists('sponsors');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('contents');
        Schema::dropIfExists('constants');
        Schema::dropIfExists('faqs');
    }
}
