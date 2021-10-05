<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('event_id');
            $table->varchar('title');
            $table->datetime('date_start');
            $table->datetime('date_finish');

            $table->bigInteger('calendar_id');
            $table->foreign('calendar_id')->references('calendar_id')->on('calendars')->onDelete('cascade');

            $table->bigInteger('creator_id');
            $table->foreign('creator_id')->references('user_id')->on('users')->onDelete('cascade');

            $table->tinyInteger('is_accepted');
            $table->tinyInteger('is_blocking');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
