<?php

declare(strict_types=1);

// 03.12.2024 at 16:14:35
namespace App\Events\Promo;

use App\Models\Promo;
use Illuminate\Foundation\Events\Dispatchable;

final class CreatedEvent
{
    use Dispatchable;

    public function __construct(
        public Promo $promo,
    ) {
    }
}
