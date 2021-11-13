<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tasks', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->longText('description');
      $table->foreignId('board_id')->constrained();
      $table->foreignId('reporter_id')->constrained('users');
      $table->foreignId('asignee_id')->constrained('users');
      $table->dateTime('start_date');
      $table->dateTime('due_date')->nullable();
      $table->enum('status', ['backlog', 'open', 'in progress', 'done', 'returned', 'verified', 'canceled']);
      $table->enum('priority', ['none', 'low', 'medium', 'high', 'urgent']);
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
    Schema::dropIfExists('tasks');
  }
}
