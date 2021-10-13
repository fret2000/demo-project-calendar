<?php

namespace Database\Seeders;

use App\Models\Calendar;
use App\Models\Event;
use App\Models\User;
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
        Calendar::firstOrCreate([
            'name' => 'Персональный календарь Василия Зайцева',
            'type' => 'personal',
            'platform' => 'google',
            'user_id' => 1,
            'platform_calendar_id'=>1
        ]);

        Calendar::firstOrCreate([
            'name' => 'Персональный календарь Тимура Родригеза',
            'type' => 'personal',
            'platform' => 'google',
            'user_id' => 2,
            'platform_calendar_id'=>1
        ]);


        Calendar::firstOrCreate([
            'name' => 'Персональный календарь Дмитрия Каперника',
            'type' => 'personal',
            'platform' => 'google',
            'user_id' => 3,
            'platform_calendar_id'=>1
        ]);

        Calendar::firstOrCreate([
            'name' => 'Персональный календарь Семена Слепакова',
            'type' => 'personal',
            'platform' => 'google',
            'user_id' => 4,
            'platform_calendar_id'=>1
        ]);

        Calendar::firstOrCreate([
            'name' => 'Персональный календарь Гарика Мартиросяна',
            'type' => 'personal',
            'platform' => 'google',
            'user_id' => 5,
            'platform_calendar_id'=>1
        ]);


        Calendar::firstOrCreate([
            'name' => 'Персональный календарь Алексея Щербакова',
            'type' => 'personal',
            'platform' => 'google',
            'user_id' => 6,
            'platform_calendar_id'=>1
        ]);

        Calendar::firstOrCreate([
            'name' => 'Календарь компании Imagespark',
            'type' => 'room',
            'platform' => 'google',
            'user_id' => 7,
            'platform_calendar_id'=>1
        ]);


    }
}
