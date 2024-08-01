<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Retailer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class RetailersDumpSeeder extends Seeder
{
    public function run()
    : void
    {
        $file = database_path('dumps/retailers.json');
        $json = File::get($file);
        $retailers = json_decode($json);

        foreach ($retailers as $retailer) {
            Retailer::create([
                'name'        => $retailer->name,
                'customer_id' => $retailer->customer_id,
                'city_id'     => $retailer->city_id,
                'type'        => $retailer->type,
                'description' => $retailer->description,
                'is_active'   => $retailer->is_active,
                'is_direct'   => $retailer->is_direct,
                'created_at'  => fake()->dateTimeInInterval('-5 years'),
                'updated_at'  => fake()->dateTimeInInterval('-2 years'),
            ]);
        }
    }
}
