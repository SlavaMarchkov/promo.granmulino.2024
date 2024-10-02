<?php

declare(strict_types=1);

// 01.10.2024 at 23:14:58
namespace App\Services\Customers\Handlers;


use App\Models\Customer;
use App\Services\Customers\Repositories\CustomerRepositoryInterface;

final readonly class CreateCustomerHandler
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
    )
    {
    }

    public function handle(array $data)
    : Customer
    {
        return $this->customerRepository->createFromArray($data);
    }
}
