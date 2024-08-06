<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'promo:install';

    protected $description = 'Installation of the project';

    public function handle()
    : int
    {
        $this->call('storage:link');
        $this->call('migrate', [
            '--force' => true,
        ]);

        return self::SUCCESS;
    }
}
