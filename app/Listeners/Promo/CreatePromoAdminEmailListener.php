<?php

declare(strict_types=1);

// 03.12.2024 at 16:39:47
namespace App\Listeners\Promo;

use App\Events\Promo\CreatedEvent;
use App\Mail\Admin\PromoCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

final class CreatePromoAdminEmailListener implements ShouldQueue
{
    public function handle(CreatedEvent $event)
    : void {
        info('Promo ID={id}, type={type} was created.', [
            'id'   => $event->promo->id,
            'type' => $event->promo->promo_type,
        ]);
        Mail::to(config('mail.to.admin'))->send(new PromoCreatedMail($event->promo));
    }
}
