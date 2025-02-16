<?php

declare(strict_types=1);

// 16.02.2025 at 12:57:32
namespace App\Services\Promos\Handlers;


use App\Models\Promo;
use App\Services\Promos\Repositories\PromoRepositoryInterface;

final class UpdatePromoSellersHandler
{
    public function __construct(
        private PromoRepositoryInterface $promoRepository,
    ) {
    }

    public function handle(Promo $promo, array $data)
    : Promo {
        return $this->promoRepository->updatePromoSellersFromArray($promo, $data);
    }
}
