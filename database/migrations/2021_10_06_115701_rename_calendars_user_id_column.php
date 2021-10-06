<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCalendarsUserIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('calendars', 'user_id')){
            Schema::table('calendars', function (Blueprint $table) {
                $table->renameColumn('user_id', 'owner_id');
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
        if(Schema::hasColumn('calendars', 'owner_id')){
            Schema::table('calendars', function (Blueprint $table) {
                $table->renameColumn('owner_id', 'user_id');
            });
        }
    }
}
