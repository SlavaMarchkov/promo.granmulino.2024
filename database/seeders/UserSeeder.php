<?php

namespace Database\Seeders;

use App\Enums\User\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    : void
    {
        User::create(
            [
                'last_name'    => 'Сотникова',
                'first_name'   => 'Галина',
                'middle_name'  => 'Александровна',
                'display_name' => null,
                'email'        => '110@altan.ru',
                'password'     => bcrypt('110@altan.ru'),
                'is_admin'     => false,
                'role_id'      => DB::table('roles')
                                      ->select('id')
                                      ->where('slug', RoleEnum::MANAGER->getName())
                                      ->pluck('id')[0],
            ],
        );

        User::create(
            [
                'last_name'    => 'Сотникова',
                'first_name'   => 'Галина',
                'middle_name'  => 'Александровна',
                'display_name' => 'Сотникова Галина (админ)',
                'email'        => '110@altan.ru',
                'password'     => bcrypt('x2AlqA2tyL4Atqu'),
                'is_admin'     => true,
                'role_id'      => DB::table('roles')
                                      ->select('id')
                                      ->where('slug', RoleEnum::ADMIN->getName())
                                      ->pluck('id')[0],
            ],
        );

        User::create(
            [
                'last_name'    => 'Марчков',
                'first_name'   => 'Вячеслав',
                'middle_name'  => 'Александрович',
                'display_name' => 'Марчков Вячеслав (супер-админ)',
                'email'        => 'slavamarchkov@gmail.com',
                'password'     => bcrypt('QmVnBaf46Jes8nPWuZcq'),
                'is_admin'     => true,
                'role_id'      => DB::table('roles')
                                      ->select('id')
                                      ->where('slug', RoleEnum::SUPER_ADMIN->getName())
                                      ->pluck('id')[0],
            ],
        );

        User::create(
            [
                'last_name'    => 'Карюкина',
                'first_name'   => 'Ольга',
                'middle_name'  => 'Михайловна',
                'display_name' => 'Карюкина О.М. (админ)',
                'email'        => '103@altan.ru',
                'password'     => bcrypt('5XcJSrKhKS6d5rU'),
                'is_admin'     => true,
                'role_id'      => DB::table('roles')
                                      ->select('id')
                                      ->where('slug', RoleEnum::PRICE_ADMIN->getName())
                                      ->pluck('id')[0],
            ],
        );
    }
}
