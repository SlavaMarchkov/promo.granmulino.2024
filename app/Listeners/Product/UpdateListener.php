<?php

declare(strict_types=1);

// 18.01.2025 at 20:31:41
namespace App\Listeners\Product;

use App\Events\Product\UpdatedEvent;
use App\Notifications\Product\UpdateProductNotification;
use Illuminate\Support\Facades\Notification;

final class UpdateListener
{
    public function __construct()
    {
    }

    public function handle(UpdatedEvent $event)
    : void {
        $data = [
            'id'       => $event->product->getAttribute('id'),
            'name'     => $event->product->getAttribute('name'),
            'category' => $event->product->category->name,
            'price'    => $event->product->getChanges()['price'],
        ];
        info('Product ID={id}, name={name} was changed.', $data);
        Notification::route('telegram', config('notifications.telegram_admin_id'))
            ->notify(
                new UpdateProductNotification($data),
            );
    }
}
