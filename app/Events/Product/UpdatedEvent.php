<?php

declare(strict_types=1);

// 18.01.2025 at 20:27:26
namespace App\Events\Product;

use App\Models\Product;
use Illuminate\Foundation\Events\Dispatchable;

final class UpdatedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly Product $product,
    ) {
    }
}
