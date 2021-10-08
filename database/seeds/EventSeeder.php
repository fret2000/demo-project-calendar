<?php

namespace Database\Seeders;

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
        DB::table('events')->insert([
            'name' => 'Дмитрий Ильин',
            'date-start' => '2021-10-08 10:00:00',
            'date-finish'=> '2021-10-08 10:15:00',
            'is_accept' => rand(0,1),
            'is_blocking' => rand(0,1)  
        ]);


        DB::table('events')->insert([
            'name' => 'Илья Дмитров',
            'date-start' => '2021-10-08 12:00:00',
            'date-finish'=> '2021-10-08 14:15:00',
            'is_accept' => rand(0,1),
            'is_blocking' => rand(0,1)  
        ]);
    }
}
