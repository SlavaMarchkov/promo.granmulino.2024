<?php

namespace Database\Seeders;

use App\Enums\User\RoleEnum;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    : void
    {
        Role::create([
            'name' => RoleEnum::SUPER_ADMIN->getValue(),
            'slug' => RoleEnum::SUPER_ADMIN->getName(),
        ]);

        Role::create([
            'name' => RoleEnum::PRICE_ADMIN->getValue(),
            'slug' => RoleEnum::PRICE_ADMIN->getName(),
        ]);

        Role::create([
            'name' => RoleEnum::ADMIN->getValue(),
            'slug' => RoleEnum::ADMIN->getName(),
        ]);

        Role::create([
            'name' => RoleEnum::MANAGER->getValue(),
            'slug' => RoleEnum::MANAGER->getName(),
        ]);
    }
}
