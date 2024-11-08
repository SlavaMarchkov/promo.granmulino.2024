<?php

declare(strict_types=1);

// 08.11.2024 at 00:33:16
namespace App\Services\Promos\Handlers;


use App\Models\Promo;
use App\Services\Promos\Repositories\PromoRepositoryInterface;

final readonly class CreatePromoHandler
{
    public function __construct(
        private PromoRepositoryInterface $promoRepository,
    )
    {
    }

    public function handle(array $data)
    : Promo
    {
        return $this->promoRepository->createFromArray($data);
    }
}
