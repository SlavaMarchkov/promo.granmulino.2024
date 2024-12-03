<?php

declare(strict_types=1);

// 03.12.2024 at 15:12:25
namespace App\Listeners\Customer;

use App\Events\Customer\CreatedEvent;
use App\Models\CustomerProfile;

final class CreateProfileListener
{
    public function handle(CreatedEvent $event)
    : void {
        CustomerProfile::query()->create([
            'customer_id' => $event->customer->id,
        ]);
    }
}
