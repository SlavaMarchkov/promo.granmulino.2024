<?php

declare(strict_types=1);

// 08.11.2024 at 00:31:07
namespace App\Services\Promos;


use App\Models\Promo;
use App\Services\Promos\Handlers\CreatePromoHandler;
use App\Services\Promos\Repositories\PromoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class PromoService
{
    public function __construct(
        private readonly PromoRepositoryInterface $promoRepository,
        private readonly CreatePromoHandler $createPromoHandler,
    ) {
    }

    public function storePromo(array $data)
    : Promo {
        return $this->createPromoHandler->handle($data);
    }

    public function getPromos(array $params = [])
    : Collection {
        return $this->promoRepository->get($params);
    }
}
