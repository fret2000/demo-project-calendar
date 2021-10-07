<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateDbmodel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('events', function(Blueprint $table)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $table->dropColumn('creator_id');
            $table->dropColumn('room_id');
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            $table->renameColumn('event_id', 'id');
            $table->renameColumn('event_title', 'title');
        });

        Schema::table('calendars', function(Blueprint $table)
        {
            $table->renameColumn('calendar_id', 'id');

            $table->string('name', 128);
            $table->string('type', 128);
            $table->string('platform', 128);
        });

        Schema::table('users', function(Blueprint $table)
        {
            $table->renameColumn('user_id', 'id');
            $table->renameColumn('user_original_id', 'original_id');

            $table->dropColumn('platform');
        });

        Schema::dropIfExists('rooms');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('room_id')->unsigned()->nullable(false);
            $table->string('room_name');
            $table->bigInteger('event_id')->unsigned();
           // $table->foreign('event_id')->references('event_id')->on('events')->onDelete('cascade');
        });

        Schema::table('users', function(Blueprint $table)
        {
            $table->renameColumn('id', 'user_id');
            $table->renameColumn('original_id', 'user_original_id');

            $table->string('platform');
        });

        Schema::table('calendars', function(Blueprint $table)
        {
            $table->renameColumn('id', 'calendar_id');
            //$table->renameColumn('user_id', 'owner_id');

            $table->dropColumn(['platform', 'name', 'type']);
        });

        Schema::table('events', function(Blueprint $table)
        {
            $table->bigInteger('creator_id');
            $table->bigInteger('room_id');

            $table->foreign('creator_id')
            ->references('user_id')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->renameColumn('id', 'event_id');

            // $table->datetime('date_start')->change();
            // $table->datetime('date_finish')->change();

            $table->renameColumn('title', 'event_title');
        });
    }
}
/*
CREATE TABLE `app-calendar`.`events` (
  `event_id` BIGINT(20) NOT NULL,
  `event_title` VARCHAR(255) NULL,
  `date_start` DATETIME NULL,
  `date_finish` DATETIME NULL,
  `calendar_id` BIGINT(20) NULL,
  `creator_id` BIGINT(20) NULL,
  `room_id` BIGINT(20) NULL,
  `is_accepted` TINYINT(4) NULL,
  `is_blocking` TINYINT(4) NULL,
  PRIMARY KEY (`event_id`),
  UNIQUE INDEX `event_id_UNIQUE` (`event_id` ASC));
*/