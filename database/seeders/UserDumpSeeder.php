<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UserDumpSeeder extends Seeder
{
    public function run()
    : void
    {
        $file = database_path('dumps/users.sql');
        $sql = File::get($file);
        DB::connection()->getPdo()->exec($sql);
    }
}