<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->string("name",30);
            $table->string("email",155);
            $table->text("password");
            $table->string("phone",20)->nullable();
            $table->string("swish_number",20)->nullable();;
            $table->string("whatsapp_number",20)->nullable();
            $table->boolean("subscribed_to_newsletter")->default(false);
            $table->boolean("verified")->default(false);
            $table->boolean("blocked")->default(false);
            $table->boolean("closed")->default(false);
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
        Schema::dropIfExists('donor');
    }
}
