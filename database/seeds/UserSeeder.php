<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    protected $users = [
        'Василий Зайцев',
        'Тимур Родригез',
        'Дмитрий Каперник',
        'Семен Слепаков',
        'Гарик Мартиросян',
        'Алексей Щербаков',
        'Imagespark'
    ];
    protected $platform = [
        'yandex',
        'google'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->users as $user) {
            $user = User::firstOrCreate([
                'name' => $user,
                'platform' => 'google',
                'user_original_id' => 1
            ]);
        }
    }
}
