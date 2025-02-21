<?php

declare(strict_types=1);

// 21.02.2025 at 12:56:25
namespace App\Services\Sales\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface SalesRepositoryInterface
{

    public function createSalesPlanFromArray(array $data)
    : Collection;
}
