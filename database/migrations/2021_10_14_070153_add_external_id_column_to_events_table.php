<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExternalIdColumnToEventsTable extends Migration
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
            /*
            Возможно не хватит длины строки
            У гугла *анись какой длинный event_id
            реальный пример: (233 символа)
27hah6vdt592iecqbse7ercfnn16bsgb3sbqa075kv2iuscapks57jp7bntj63folhfn3f83qjhtt1anrvsdn1rsk5d9r1v2a6bkj1gg_20211012T160000Zanrvsdn1rsk5d9r1v2a6bkj1gg_20211013T160000Z323afrs0rd8shtkbjhanmhftos_20211015T120000Znvs9ahb8v5e4siib7if3oc44c4
            */
            $table->string('external_id')->default(0);
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
            $table->dropColumn('external_id');
        });
    }
}
