<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CitiesDumpSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('dumps/cities.json');
        $json = File::get($file);
        $cities = json_decode($json);

        foreach ($cities as $city) {
            City::create([
                'id'         => $city->id,
                'name'       => $city->name,
                'region_id'  => $city->region_id,
                'created_at' => fake()->dateTimeInInterval('-5 years'),
                'updated_at' => fake()->dateTimeInInterval('-3 years'),
            ]);
        }
    }
}
