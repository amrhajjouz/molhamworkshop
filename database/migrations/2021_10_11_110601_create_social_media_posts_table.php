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
            $table->enum('status' , ['pending' , 'approved' , 'rejected'])->index()->default('pending');
            $table->datetime('archived_at')->nullable();
            $table->bigInteger('rejected_by')->nullable();
            $table->datetime('rejected_at')->nullable();
            $table->bigInteger('approved_by')->nullable();
            $table->datetime('approved_at')->nullable();
            $table->datetime('published_on_facebook_at')->nullable();
            $table->datetime('published_on_twitter_at')->nullable();
            $table->datetime('published_on_instagram_at')->nullable();
            $table->datetime('published_on_youtube_at')->nullable();
            $table->datetime('scheduled_on_facebook_at')->nullable();
            $table->datetime('scheduled_on_twitter_at')->nullable();
            $table->datetime('scheduled_on_instagram_at')->nullable();
            $table->datetime('scheduled_on_youtube_at')->nullable();
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
