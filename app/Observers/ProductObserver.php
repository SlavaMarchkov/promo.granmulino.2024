<?php

declare(strict_types=1);

// 18.01.2025 at 20:19:28
namespace App\Observers;

use App\Events\Product\UpdatedEvent;
use App\Models\Product;

final class ProductObserver
{

    public function updated(Product $product)
    : void {
        event(new UpdatedEvent($product));
    }
}
