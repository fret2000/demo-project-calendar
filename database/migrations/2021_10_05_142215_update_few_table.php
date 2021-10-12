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
        Schema::enableForeignKeyConstraints();

        Schema::table('calendars', function(Blueprint $table)
        {
            $table->foreign('user_id')
            ->references('user_id')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });

        Schema::table("rooms", function(Blueprint $table)
        {
            $table->foreign('event_id')
            ->references('event_id')
            ->on('events')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });

        Schema::table('events', function(Blueprint $table)
        {
            $table->foreign('calendar_id')
            ->references('calendar_id')
            ->on('calendars')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('creator_id')
            ->references('user_id')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function(Blueprint $table)
        {
            $table->dropForeign('events_calendar_id_foreign', 'events_creator_id_foreign');
        });

        Schema::table('rooms', function(Blueprint $table)
        {
            $table->dropForeign('rooms_event_id_foreign');
        });

        Schema::table('calendars', function(Blueprint $table)
        {
            $table->dropForeign('calendars_user_id_foreign');
        });

        Schema::disableForeignKeyConstraints();
    }
}
