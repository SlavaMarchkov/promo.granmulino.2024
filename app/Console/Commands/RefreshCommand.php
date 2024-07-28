<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RefreshCommand extends Command
{
    protected $signature = 'promo:refresh';

    protected $description = 'Refreshing and seeding database';

    public function handle()
    : int
    {
        if (app()->environment() === 'production') {
            $this->error('No refresh database in production mode!');
            return self::FAILURE;
        }

        $this->call('migrate:fresh', [
            '--seed' => true,
        ]);

        return self::SUCCESS;
    }
}
