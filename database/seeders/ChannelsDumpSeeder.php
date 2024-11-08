<?php

declare(strict_types=1);

// 08.11.2024 at 21:02:01
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ChannelsDumpSeeder extends Seeder
{
    public function run()
    : void
    {
        $file = database_path('dumps/channels.sql');
        $sql = File::get($file);
        DB::connection()->getPdo()->exec($sql);
    }
}
