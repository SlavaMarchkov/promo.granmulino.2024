<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class RegionsDumpSeeder extends Seeder
{
    /*public function run()
    : void
    {
        $csvData = fopen(base_path('database/dumps/regions.csv'), 'r');

        $transRow = true;
        while (($data = fgetcsv($csvData, 555, ',')) !== false) {
            if (!$transRow) {
                Region::create([
                    'id'         => $data['0'],
                    'code'       => $data['1'],
                    'name'       => $data['2'],
                    'created_at' => $data['3'],
                    'updated_at' => $data['4'],
                ]);
            }
            $transRow = false;
        }

        fclose($csvData);
    }*/

    public function run()
    : void
    {
        $file = database_path('dumps/regions.json');
        $json = File::get($file);
        $regions = json_decode($json);

        foreach ($regions as $region) {
            Region::create([
                'id'         => $region->id,
                'code'       => $region->code,
                'name'       => $region->name,
                'created_at' => $region->created_at,
                'updated_at' => $region->updated_at,
            ]);
        }
    }
}
