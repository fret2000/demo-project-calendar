<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('calendars')->insert([
            'name' => 'Персональный календарь Дмитрия',
            'type' => 'personal',
            'platform'=> 'yandex'
        ]);


        DB::table('calendars')->insert([
            'name' => 'Персональный календарь Алексея',
            'type' => 'personal',
            'platform'=> 'yandex'
        ]);



        DB::table('calendars')->insert([
            'name' => 'Персональный календарь Александра',
            'type' => 'personal',
            'platform'=> 'yandex'
        ]);




        DB::table('calendars')->insert([
            'name' => 'День рождения',
            'type' => 'room',
            'platform'=> 'yandex'
        ]);




        DB::table('calendars')->insert([
            'name' => 'Обучение персонала',
            'type' => 'room',
            'platform'=> 'yandex'
        ]);

        DB::table('calendars')->insert([
            'name' => 'День города',
            'type' => 'room',
            'platform'=> 'yandex'
        ]);
    }
}
