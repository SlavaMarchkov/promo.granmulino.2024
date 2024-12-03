<?php

declare(strict_types=1);

// 03.12.2024 at 16:58:06
namespace App\Notifications;

use App\Mail\Admin\LoginMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;

class LoginAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
    }

    public function via(User $notifiable)
    : array {
        return ['mail'];
    }

    public function toMail(User $notifiable)
    : Mailable {
        return (new LoginMail($notifiable))->to(config('mail.to.admin'));
    }

    public function toArray($notifiable)
    : array {
        return [];
    }
}
