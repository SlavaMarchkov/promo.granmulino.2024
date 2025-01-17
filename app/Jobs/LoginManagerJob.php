<?php

declare(strict_types=1);

// 03.12.2024 at 12:47:46
namespace App\Jobs;

use App\Models\User;
use App\Notifications\LoginTelegramNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

final class LoginManagerJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly User $user,
    ) {
    }

    public function handle()
    : void
    {
        info('User ID={id} just logged in.', ['id' => $this->user->id]);
//        Mail::to(config('mail.to.admin'))->send(new LoginMail($this->user));
        Notification::route('telegram', config('notifications.telegram_admin_id'))
            ->notify(
                new LoginTelegramNotification([
                    'name' => $this->user['fullName'],
                ]),
            );
    }
}
