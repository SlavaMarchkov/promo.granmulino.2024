<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductsDumpSeeder extends Seeder
{
    public function run()
    : void
    {
        $file = database_path('dumps/products.json');
        $json = File::get($file);
        $products = json_decode($json);

        foreach ($products as $product) {
            Product::create([
                'name'        => $product->name,
                'price'       => 0.00,
                'is_active'   => $product->is_active,
                'category_id' => $product->group_id,
                'created_at'  => fake()->dateTimeInInterval('-5 years'),
                'updated_at'  => fake()->dateTimeInInterval('-4 years'),
            ]);
        }
    }
}
