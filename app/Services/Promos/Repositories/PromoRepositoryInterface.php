<?php

declare(strict_types=1);

// 08.11.2024 at 00:31:51
namespace App\Services\Promos\Repositories;

use App\Models\Promo;

interface PromoRepositoryInterface
{
    public function createFromArray(array $data)
    : Promo;
}
