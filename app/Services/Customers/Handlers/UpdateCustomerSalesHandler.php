<?php

declare(strict_types=1);

// 15.03.2025 at 15:37:52
namespace App\Services\Customers\Handlers;


use App\Models\CustomerSales;
use App\Services\Customers\Repositories\CustomerRepositoryInterface;

final readonly class UpdateCustomerSalesHandler
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
    ) {
    }

    public function handle(CustomerSales $sales, array $data)
    : CustomerSales {
        return $this->customerRepository->updateSalesPlanFromArray($sales, $data);
    }
}
