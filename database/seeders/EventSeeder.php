<?php

namespace Database\Seeders;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::create([
            'title' => 'Совещание',
            'date_start' => '2021-10-08 10:00:00',
            'date_finish'=> '2021-10-08 10:15:00',
            'is_accepted' => rand(0,1),
            'is_blocking' => rand(0,1),
            'calendar_id' => 1,
        ]);


        Event::create([
            'title' => 'Совещание 2',
            'date_start' => '2021-10-08 12:00:00',
            'date_finish'=> '2021-10-08 14:15:00',
            'is_accepted' => rand(0,1),
            'is_blocking' => rand(0,1),
            'calendar_id' => 2,

        ]);

        Event::create([
            'title' => 'Совещание 3',
            'date_start' => '2021-10-07 12:00:00',
            'date_finish'=> '2021-10-07 14:15:00',
            'is_accepted' => rand(0,1),
            'is_blocking' => rand(0,1),
            'calendar_id' => 3,
        ]);

        Event::create([
            'title' => 'Совещание 4',
            'date_start' => '2021-10-07 12:00:00',
            'date_finish'=> '2021-10-08 14:15:00',
            'is_accepted' => rand(0,1),
            'is_blocking' => rand(0,1),
            'calendar_id' => 3,
        ]);


        Event::create([
            'title' => 'Совещание 6',
            'date_start' => '2021-10-07 12:00:00',
            'date_finish'=> '2021-10-08 14:15:00',
            'is_accepted' => rand(0,1),
            'is_blocking' => rand(0,1),
            'calendar_id' => 2,
        ]);


        Event::create([
            'title' => 'Совещание 7',
            'date_start' => '2021-10-09 12:00:00',
            'date_finish'=> '2021-10-08 14:15:00',
            'is_accepted' => rand(0,1),
            'is_blocking' => rand(0,1),
            'calendar_id' => 1,
        ]);


    }
}
