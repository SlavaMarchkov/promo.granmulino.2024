<?php

declare(strict_types=1);

// 17.01.2025 at 19:52:00
namespace App\Notifications;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class SignInAttemptTelegramNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly array $data,
    ) {
    }

    public function via(object $notifiable)
    : array {
        return [TelegramChannel::class];
    }

    /**
     * @throws Exception
     */
    public function toTelegram(object $notifiable)
    {
        try {
            return TelegramMessage::create()
                ->to(config('notifications.telegram_admin_id'))
                ->content('AUTH :: Попытка входа в систему' . "\n" . 'Guard: ' . $this->data['guard'] . "\n" . 'Email: ' . $this->data['email'] . "\n" . 'Пароль: ' . $this->data['password']);
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception();
        }
    }

    public function toArray(object $notifiable)
    : array {
        return [];
    }
}
