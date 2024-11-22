<?php

declare(strict_types=1);

// 22.11.2024 at 22:12:58
namespace App\Services\Customers\Handlers;


use App\Models\CustomerSeller;
use App\Services\Customers\Repositories\CustomerRepositoryInterface;

final readonly class CreateCustomerSellerHandler
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
    )
    {
    }

    public function handle(array $data)
    : CustomerSeller
    {
        return $this->customerRepository->createSellerFromArray($data);
    }
}
