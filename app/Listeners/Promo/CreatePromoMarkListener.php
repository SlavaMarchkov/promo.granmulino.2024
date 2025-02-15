<?php

declare(strict_types=1);

// 03.12.2024 at 16:18:12
namespace App\Listeners\Promo;

use App\Events\Promo\CreatedEvent;
use App\Models\PromoMark;

final class CreatePromoMarkListener
{
    /**
     * При создании промо-акции создает запись в таблице оценок промо-акции
     *
     * @param CreatedEvent $event
     * @return void
     */
    public function handle(CreatedEvent $event)
    : void {
        PromoMark::query()->create([
            'promo_id' => $event->promo->id,
        ]);
    }
}
