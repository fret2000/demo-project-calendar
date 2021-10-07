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
            'name' => Str::random(10),
            'date-start' => Carbon::now(),
            'date-finish'=> Carbon::now()->addMinute(random_int(0,7200)),
            'is_accept' => rand(0,1),
            'is_blocking' => rand(0,1)  
        ]);
    }
}
