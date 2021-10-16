<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialMediaPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_media_posts', function (Blueprint $table) {
            $table->id();
            $table->string('description')->index();
            $table->json('body');
            $table->boolean('ready_to_publish')->default(0);
            $table->datetime('published_at')->nullable();
            $table->enum('status' , ['pending' , 'approved' , 'rejected'])->index()->default('pending');
            $table->bigInteger('rejected_by')->nullable();
            $table->datetime('rejected_at')->nullable();
            $table->bigInteger('approved_by')->nullable();
            $table->datetime('approved_at')->nullable();
            $table->datetime('published_facebook_at')->nullable();
            $table->datetime('published_twitter_at')->nullable();
            $table->datetime('published_instagram_at')->nullable();
            $table->datetime('published_youtube_at')->nullable();
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
        Schema::dropIfExists('social_media_posts');
    }
}
