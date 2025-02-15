<?php

declare(strict_types=1);

// 03.12.2024 at 21:18:06
namespace App\Observers;

use App\Events\Promo\CreatedEvent;
use App\Models\Promo;

final class PromoObserver
{
    // При создании промо-акции
    public function created(Promo $promo)
    : void {
        // 1. создается запись в таблице оценок промо-акции
        // 2. рассылаются уведомления в TG-бот или на email
        // 3. TODO создается уведомление в базе данных
        event(new CreatedEvent($promo));
    }

    public function updated(Promo $promo)
    : void {
        //if ($promo->wasChanged()) {}
//                dump($promo->getOriginal());
//                dump($promo->getAttributes());
//            }
        //event(new UpdatedEvent($promo));
    }

    public function saved(Promo $promo)
    : void {
    }

    public function deleted(Promo $promo)
    : void {
    }

    public function restored(Promo $promo)
    : void {
    }

    public function retrieved(Promo $promo)
    : void {
    }
}
