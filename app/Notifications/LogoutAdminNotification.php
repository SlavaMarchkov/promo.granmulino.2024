<?php

declare(strict_types=1);

// 03.12.2024 at 19:29:55
namespace App\Notifications;

use App\Mail\Admin\LogoutMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;

class LogoutAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
    }

    public function via($notifiable)
    : array {
        return ['mail'];
    }

    public function toMail(User $notifiable)
    : Mailable {
        return (new LogoutMail($notifiable))->to(config('mail.to.admin'));
    }

    public function toArray($notifiable)
    : array {
        return [];
    }
}
