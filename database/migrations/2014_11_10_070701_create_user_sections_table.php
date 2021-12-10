<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sections', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->index()->nullable();
            $table->json('section_name');
            $table->foreignId('user_manager_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('user_sections', function (Blueprint $table) {
              $table->dropSoftDeletes();
          });
    }
}
