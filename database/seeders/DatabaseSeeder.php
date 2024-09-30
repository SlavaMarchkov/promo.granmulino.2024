<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    : void
    {
        $this->call([
            RoleSeeder::class,
            UserDumpSeeder::class,
            RegionsDumpSeeder::class,
            CitiesDumpSeeder::class,
            CategoriesDumpSeeder::class,
            ProductsDumpSeeder::class,
            CustomersDumpSeeder::class,
            RetailersDumpSeeder::class,
        ]);
    }
}
