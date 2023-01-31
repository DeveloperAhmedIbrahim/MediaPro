<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('image_url')->nullable();
            $table->string('add_watermark')->nullable();
        $table->string('name')->nullable();
        $table->string('user_id')->nullable();
        $table->string('tag')->nullable();
        $table->string('responsive')->nullable();
        $table->string('fixed')->nullable();
        $table->integer('autoplay')->nullable();
        $table->integer('volume')->nullable();
        $table->integer('showcontrols')->nullable();
        $table->integer('show_content_title')->nullable();
        $table->integer('show_share_buttons')->nullable();
        $table->string('code')->nullable();
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
        Schema::dropIfExists('videos');
    }
}
