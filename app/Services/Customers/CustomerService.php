<?php

declare(strict_types=1);

// 01.10.2024 at 23:12:27
namespace App\Services\Customers;


use App\Models\Customer;
use App\Services\Customers\Handlers\CreateCustomerHandler;
use App\Services\Customers\Repositories\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class CustomerService
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private CreateCustomerHandler       $createCustomerHandler,
    )
    {
    }

    public function findCustomer(Customer $customer)
    : ?Customer
    {
        return $this->customerRepository->find($customer);
    }

    public function getCustomers(array $params)
    : Collection
    {
        return $this->customerRepository->get($params);
    }

    public function storeCustomer(array $data)
    : Customer
    {
        return $this->createCustomerHandler->handle($data);
    }

    public function updateCustomer(Customer $customer, array $data)
    : Customer
    {
        return $this->customerRepository->updateFromArray($customer, $data);
    }

    public function deleteCustomer(Customer $customer)
    : int
    {
        return $this->customerRepository->delete($customer);
    }
}
