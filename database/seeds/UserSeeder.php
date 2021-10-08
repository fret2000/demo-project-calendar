<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Василий Зайцев'
        ]);

        DB::table('users')->insert([
            'name' => 'Тимур Родригез'
        ]);


        DB::table('users')->insert([
            'name' => 'Дмитрий Каперник'
        ]);


        DB::table('users')->insert([
            'name' => 'Семен Слепаков'
        ]);


        DB::table('users')->insert([
            'name' => 'Гарик Мартиросян'
        ]);


        DB::table('users')->insert([
            'name' => 'Алексей Щербаков'
        ]);
    }
}
