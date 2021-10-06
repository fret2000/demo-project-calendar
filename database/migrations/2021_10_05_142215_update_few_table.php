<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("calendars", function(Blueprint $table)
        {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
/*
        Schema::table("rooms", function(Blueprint $table)
        {
            $table->foreign('event_id')->references('event_id')->on('events')->onDelete('cascade');
        });
        

        Schema::table("events", function(Blueprint $table)
        {
            $table->foreign('calendar_id')->references('calendar_id')->on('calendars')->onDelete('cascade');
            $table->foreign('creator_id')->references('user_id')->on('users')->onDelete('cascade');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendars', function($table)
        {
            $table->dropForeign(['user_id']);
        });

        Schema::table('rooms', function($table)
        {
            $table->dropForeign(['event_id']);
        });

        Schema::table('events', function($table)
        {
            $table->dropForeign(['calendar_id']);
            $table->dropForeign(['creator_id']);
        });
    }
}
