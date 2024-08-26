<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductsDumpSeeder extends Seeder
{
    /*public function run()
    : void
    {
        $file = database_path('dumps/products.json');
        $json = File::get($file);
        $products = json_decode($json);

        $pack_weights = [
            400,
            450,
            600,
            700,
            800,
            1000,
            2000,
        ];

        foreach ($products as $product) {
            Product::create([
                'name'        => $product->name,
                'weight'      => $pack_weights[array_rand($pack_weights)],
                'price'       => fake()->randomFloat(2, 50, 90),
                'is_active'   => $product->is_active,
                'category_id' => $product->group_id,
                'created_at'  => fake()->dateTimeInInterval('-5 years'),
                'updated_at'  => fake()->dateTimeInInterval('-4 years'),
            ]);
        }
    }*/

    public function run()
    : void
    {
        $file = database_path('dumps/products.sql');
        $sql = File::get($file);
        DB::connection()->getPdo()->exec($sql);
    }
}
