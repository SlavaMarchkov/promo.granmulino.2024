<?php

declare(strict_types=1);

// 21.02.2025 at 12:54:10
namespace App\Services\Sales;


use App\Services\Sales\Handlers\CreateSalesPlanHandler;
use App\Services\Sales\Repositories\SalesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class SalesService
{
    public function __construct(
        private SalesRepositoryInterface $salesRepository,
        private CreateSalesPlanHandler $createSalesPlanHandler,
    )
    {
    }

    public function createSalesPlan(array $data)
    : Collection {
        return $this->createSalesPlanHandler->handle($data);
    }
}
