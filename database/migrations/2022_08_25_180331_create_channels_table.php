<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('schedule_duration')->nullable();
            $table->string('user_id')->nullable();
            $table->string('videos')->nullable();
            $table->string('time')->nullable();
            $table->integer('controllogo')->nullable();
            $table->string('logo')->nullable();
            $table->integer('positionleft')->nullable();
            $table->integer('positionright')->nullable();
            $table->integer('anywhere')->nullable();
            $table->integer('choose_domain')->nullable();
            $table->string('adtagurl')->nullable();
            $table->integer('ChanelType')->nullable();
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
        Schema::dropIfExists('channels');
    }
}
