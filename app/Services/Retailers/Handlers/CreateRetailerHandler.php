<?php

declare(strict_types=1);

// 03.10.2024 at 23:09:56
namespace App\Services\Retailers\Handlers;


use App\Models\Retailer;
use App\Services\Retailers\Repositories\RetailerRepositoryInterface;

final readonly class CreateRetailerHandler
{
    public function __construct(
        private RetailerRepositoryInterface $retailerRepository,
    )
    {
    }

    public function handle(array $data)
    : Retailer
    {
        return $this->retailerRepository->createFromArray($data);
    }
}
