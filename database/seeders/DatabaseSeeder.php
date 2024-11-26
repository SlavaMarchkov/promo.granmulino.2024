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
            RetailersDumpSeeder::class,
            ChannelsDumpSeeder::class,
            CustomersDumpSeeder::class,
            CustomerSellersDumpSeeder::class,
        ]);
    }
}
