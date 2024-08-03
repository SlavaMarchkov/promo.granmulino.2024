<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    : void
    {
        Admin::create(
            [
                'name'     => 'SuperAdministrator',
                'email'    => 'carolunas@yandex.ru',
                'is_super' => true,
                'password' => Hash::make('carolunas@yandex.ru'),
            ]
        );

        Admin::create(
            [
                'name'     => 'Slava Marchello',
                'email'    => 'slavamarchkov@yandex.ru',
                'is_super' => false,
                'password' => Hash::make('slavamarchkov@yandex.ru'),
            ]
        );
    }
}
