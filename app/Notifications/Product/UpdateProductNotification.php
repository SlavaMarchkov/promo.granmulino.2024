<?php

declare(strict_types=1);

// 18.01.2025 at 21:07:10
namespace App\Notifications\Product;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class UpdateProductNotification extends Notification implements ShouldQueue
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
                ->content(
                    'ADMIN :: Обновление продукта' . "\n" .
                    'Продукт: ' . $this->data['name'] . "\n" .
                    'Группа товара: ' . $this->data['category'] . "\n" .
                    'Цена: ' . $this->data['price'],
                );
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
