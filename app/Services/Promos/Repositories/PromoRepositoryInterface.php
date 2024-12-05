<?php

declare(strict_types=1);

// 08.11.2024 at 00:31:51
namespace App\Services\Promos\Repositories;

use App\Models\Promo;
use Illuminate\Database\Eloquent\Collection;

interface PromoRepositoryInterface
{
    public function get(array $params = [])
    : Collection;

    public function createFromArray(array $data)
    : Promo;
}
