<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTargets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs_targets', function (Blueprint $table) {
            $table->id();
            $table->string('reference' , 15)->unique();
            $table->string('code' , 20)->unique(); // TODO => for each targetable model 
            $table->morphs('targetable');
            $table->bigInteger('program_id')->index()->nullable();
            $table->bigInteger('category_id')->index()->nullable();
            $table->integer('required')->index()->default(0);
            $table->integer('received')->index()->default(0);
            $table->integer('left_to_complete')->index()->default(0);
            $table->integer('spent')->index()->default(0);
            $table->integer('left')->index()->default(0);
            $table->integer('beneficiaries_count')->index()->default(0);
            $table->boolean('archived')->index()->default(0);
            $table->boolean('documented')->index()->default(0);
            $table->boolean('hidden')->index()->default(1);
            // $table->boolean('posted')->index()->default(0); TODO : when posted at equal null that mean posted = false
            $table->dateTime('posted_at')->nullable();
            $table->dateTime('canceled_at')->nullable();
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
        Schema::dropIfExists('programs_targets');
    }
}
