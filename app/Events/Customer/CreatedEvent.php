<?php

declare(strict_types=1);

// 03.12.2024 at 15:09:31
namespace App\Events\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Events\Dispatchable;

final class CreatedEvent
{
    use Dispatchable;

    public function __construct(
        public Customer $customer,
    ) {
    }
}
