<?php

declare(strict_types=1);

// 09.11.2024 at 21:54:41
namespace App\Services\Promos\Repositories;


use App\Models\Promo;

final class EloquentPromoRepository implements PromoRepositoryInterface
{

    public function createFromArray(array $data)
    : Promo
    {
        $products = $data['products'];
        unset($data['products']);

        $promo = Promo::query()->create($data);
        $promo->promo_products()->createMany($products);

        return $promo;
    }
}
