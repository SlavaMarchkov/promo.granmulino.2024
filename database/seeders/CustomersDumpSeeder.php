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
                'data'        => $customer->data,
                'is_active'   => $customer->is_active,
                'created_at'  => $customer->created_at,
                'updated_at'  => $customer->updated_at,
            ]);
        }
    }


    /*public function run()
    : void
    {
        $file = database_path('dumps/customers.sql');
        $sql = File::get($file);
        DB::connection()->getPdo()->exec($sql);
    }*/
}
