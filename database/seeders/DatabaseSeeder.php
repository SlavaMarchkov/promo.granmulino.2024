<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    : void
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            RegionsDumpSeeder::class,
            CitiesDumpSeeder::class,
            CategoriesDumpSeeder::class,
            ProductsDumpSeeder::class,
            CustomersDumpSeeder::class,
            RetailersDumpSeeder::class,
        ]);
    }
}
