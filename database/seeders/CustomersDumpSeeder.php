<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CustomersDumpSeeder extends Seeder
{
    public function run()
    : void
    {
        $file = database_path('dumps/customers.json');
        $json = File::get($file);
        $customers = json_decode($json);

        foreach ($customers as $customer) {
            Customer::create([
                'name'        => $customer->name,
                'region_id'   => $customer->region_id,
                'city_id'     => $customer->city_id,
                'user_id'     => $customer->user_id,
                'description' => $customer->description,
                'is_active'   => $customer->is_active,
                'created_at'  => fake()->dateTimeInInterval('-5 years'),
                'updated_at'  => fake()->dateTimeInInterval('-2 years'),
            ]);
        }
    }
}
