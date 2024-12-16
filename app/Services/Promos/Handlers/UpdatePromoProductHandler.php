<?php

declare(strict_types=1);

// 16.12.2024 at 22:32:56
namespace App\Services\Promos\Handlers;


use App\Models\PromoProduct;
use App\Services\Promos\Repositories\PromoRepositoryInterface;

final readonly class UpdatePromoProductHandler
{
    public function __construct(
        private PromoRepositoryInterface $promoRepository,
    ) {
    }

    public function handle(int $promo_id, PromoProduct $promoProduct, array $data)
    : PromoProduct {
        return $this->promoRepository->updatePromoProductFromArray($promo_id, $promoProduct, $data);
    }
}
