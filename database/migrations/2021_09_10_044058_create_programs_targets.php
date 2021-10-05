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
            $table->string('code' , 20)->unique()->nullable(); 
            $table->morphs('targetable');
            $table->bigInteger('program_id')->index()->nullable();
            $table->bigInteger('category_id')->index()->nullable();
            $table->integer('required')->index()->default(0);
            $table->integer('received')->index()->default(0);
            $table->integer('left_to_complete')->index()->default(0);
            $table->integer('spent')->index()->default(0);
            $table->integer('left')->index()->default(0);
            $table->integer('beneficiaries_count')->index()->default(0);
            $table->json('title')->nullable();
            $table->json('description')->nullable();
            $table->json('details')->nullable();
            $table->boolean('archived')->index()->default(0);
            $table->boolean('documented')->index()->default(0);
            $table->boolean('is_hidden')->index()->default(1);
            $table->boolean('publishable')->index()->default(0);
            $table->dateTime('published_at')->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->json('available_locales');
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
