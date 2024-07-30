<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CategoriesDumpSeeder extends Seeder
{
    public function run()
    : void
    {
        $file = database_path('dumps/categories.json');
        $json = File::get($file);
        $categories = json_decode($json);

        foreach ($categories as $category) {
            Category::create([
                'id'         => $category->id,
                'name'       => $category->name,
                'is_active'  => $category->is_active,
                'created_at' => fake()->dateTimeInInterval('-5 years'),
                'updated_at' => fake()->dateTimeInInterval('-4 years'),
            ]);
        }
    }
}
