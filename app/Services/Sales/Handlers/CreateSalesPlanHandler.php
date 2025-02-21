<?php

declare(strict_types=1);

// 21.02.2025 at 12:55:41
namespace App\Services\Sales\Handlers;


use App\Services\Sales\Repositories\SalesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class CreateSalesPlanHandler
{

    public function __construct(
        private SalesRepositoryInterface $salesRepository,
    )
    {
    }

    public function handle(array $data)
    : Collection {
        return $this->salesRepository->createSalesPlanFromArray($data);
    }
}
