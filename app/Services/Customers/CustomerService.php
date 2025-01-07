<?php

declare(strict_types=1);

// 01.10.2024 at 23:12:27
namespace App\Services\Customers;


use App\Models\Customer;
use App\Models\CustomerSeller;
use App\Services\Customers\Handlers\CreateCustomerHandler;
use App\Services\Customers\Handlers\CreateCustomerProductHandler;
use App\Services\Customers\Handlers\CreateCustomerSellerHandler;
use App\Services\Customers\Handlers\UpdateCustomerSellerHandler;
use App\Services\Customers\Repositories\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class CustomerService
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private CreateCustomerHandler $createCustomerHandler,
        private CreateCustomerSellerHandler $createSellerHandler,
        private UpdateCustomerSellerHandler $updateSellerHandler,
        private CreateCustomerProductHandler $createProductHandler,
    ) {
    }

    public function findCustomer(Customer $customer, array $params = [])
    : ?Customer {
        return $this->customerRepository->find($customer, $params);
    }

    public function getCustomers(array $params = [])
    : Collection {
        return $this->customerRepository->get($params);
    }

    public function storeCustomer(array $data)
    : Customer {
        return $this->createCustomerHandler->handle($data);
    }

    public function storeSeller(array $data)
    : CustomerSeller {
        return $this->createSellerHandler->handle($data);
    }

    public function updateCustomer(Customer $customer, array $data)
    : Customer {
        return $this->customerRepository->updateFromArray($customer, $data);
    }

    public function deleteCustomer(Customer $customer)
    : int {
        return $this->customerRepository->delete($customer);
    }

    public function getCustomerSellers(int $customer_id)
    : Collection {
        return $this->customerRepository->getSellers($customer_id);
    }

    public function getCustomerProducts(int $customer_id)
    : Collection {
        return $this->customerRepository->getProducts($customer_id);
    }

    public function updateCustomerSeller(CustomerSeller $customerSeller, array $data)
    : CustomerSeller {
        return $this->updateSellerHandler->handle($customerSeller, $data);
    }

    public function findCustomerSeller(int $id)
    : ?CustomerSeller {
        return $this->customerRepository->findSeller($id);
    }

    public function deleteSeller(CustomerSeller $seller)
    : int {
        return $this->customerRepository->deleteSeller($seller);
    }

    public function storeCustomerProducts(Customer $customer, array $data)
    : Collection {
        return $this->createProductHandler->handle($customer, $data);
    }
}
