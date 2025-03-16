<?php

declare(strict_types=1);

// 12.03.2025 at 21:30:22
namespace App\Services\Customers\Handlers;


use App\Models\Customer;
use App\Services\Customers\Repositories\CustomerRepositoryInterface;

final readonly class CreateCustomerSalesHandler
{

    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
    ) {
    }

    public function handle(Customer $customer, array $data)
    : void {
        $this->customerRepository->createSalesPlanFromArray($customer, $data);
    }
}
