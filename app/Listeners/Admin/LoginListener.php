<?php

declare(strict_types=1);

// 03.12.2024 at 19:27:05
namespace App\Listeners\Admin;

use App\Notifications\LoginTelegramNotification;
use Illuminate\Auth\Events\Login;

final class LoginListener
{
    public function handle(Login $event)
    : void {
        $event->user->notify(new LoginTelegramNotification([
            'name' => $event->user['display_name'],
        ]));
    }
}
