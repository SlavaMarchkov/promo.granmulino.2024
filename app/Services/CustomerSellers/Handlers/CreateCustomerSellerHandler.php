<?php

declare(strict_types=1);

// 15.11.2024 at 18:03:39
namespace App\Services\CustomerSellers\Handlers;


use App\Models\CustomerSeller;
use App\Services\CustomerSellers\Repositories\CustomerSellerRepositoryInterface;

final readonly class CreateCustomerSellerHandler
{
    public function __construct(
        private CustomerSellerRepositoryInterface $customerSellerRepository,
    ) {
    }

    public function handle(array $data)
    : CustomerSeller {
        return $this->customerSellerRepository->createFromArray($data);
    }
}
