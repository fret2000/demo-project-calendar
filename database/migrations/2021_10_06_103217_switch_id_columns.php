<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SwitchIdColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('rooms', 'event_id'))
        {
            Schema::table('rooms', function (Blueprint $table){
                $table->dropForeign('rooms_event_id_foreign');
            });

            Schema::table('rooms', function (Blueprint $table){
                $table->dropColumn('event_id');
            });
        }

        if(Schema::hasTable('events'))
        {
            Schema::table('events', function (Blueprint $table){
                $table->bigInteger('room_id')->unsigned();
            });

            Schema::table('events', function (Blueprint $table){
                $table->foreign('room_id')
                ->references('room_id')
                ->on('rooms')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasColumn('events', 'room_id'))
        {
            Schema::table('events', function (Blueprint $table){
                $table->dropForeign('events_room_id_foreign');
            });

            Schema::table('events', function (Blueprint $table){
                $table->dropColumn('room_id');
            });
        }
        if(Schema::hasTable('rooms'))
        {
            Schema::table('rooms', function (Blueprint $table){
                $table->bigInteger('event_id')->unsigned();
            });

            Schema::table('rooms', function (Blueprint $table){
                $table->foreign('event_id')
                ->references('event_id')
                ->on('events')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            });
        }
    }
}
