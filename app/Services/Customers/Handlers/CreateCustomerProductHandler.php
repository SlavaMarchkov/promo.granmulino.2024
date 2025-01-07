<?php

declare(strict_types=1);

// 07.01.2025 at 18:27:32
namespace App\Services\Customers\Handlers;


use App\Models\Customer;
use App\Services\Customers\Repositories\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class CreateCustomerProductHandler
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
    ) {
    }

    public function handle(Customer $customer, array $data)
    : Collection {
        return $this->customerRepository->createProductsFromArray($customer, $data);
    }
}
