<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    : array
    {
        return [
            'name'       => $this->faker->name(),
            'weight'     => $this->faker->randomNumber(),
            'price'      => $this->faker->randomFloat(),
            'is_active'  => $this->faker->boolean(),
            'image'      => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            // 'category_id' => Category::factory(),
        ];
    }
}
