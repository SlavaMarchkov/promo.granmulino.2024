<?php

declare(strict_types=1);

// 03.12.2024 at 19:27:05
namespace App\Listeners\Admin;

use App\Notifications\LogoutAdminNotification;
use Illuminate\Auth\Events\Logout;

final class LogoutListener
{
    public function handle(Logout $event)
    : void {
        $event->user->notify(new LogoutAdminNotification());
    }
}
