<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Admin\RoleEnum;
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
                'name'     => 'Сотникова Галина (админ)',
                'email'    => '110@altan.ru',
                'role'     => RoleEnum::ADMIN->value,
                'password' => Hash::make('x2AlqA2tyL4Atqu'),
            ]
        );

        Admin::create(
            [
                'name'     => 'SuperAdministrator',
                'email'    => 'carolunas@yandex.ru',
                'role' => RoleEnum::SUPER_ADMIN->value,
                'password' => Hash::make('carolunas@yandex.ru'),
            ]
        );

        Admin::create(
            [
                'name'     => 'Карюкина О.М. (админ)',
                'email'    => '103@altan.ru',
                'role'     => RoleEnum::PRICE_ADMIN->value,
                'password' => Hash::make('5XcJSrKhKS6d5rU'),
            ]
        );
    }
}
