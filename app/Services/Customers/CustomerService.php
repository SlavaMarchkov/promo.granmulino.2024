<?php

declare(strict_types=1);

// 01.10.2024 at 23:12:27
namespace App\Services\Customers;


use App\Models\Customer;
use App\Models\CustomerSeller;
use App\Models\CustomerSupervisor;
use App\Services\Customers\Handlers\CreateCustomerHandler;
use App\Services\Customers\Handlers\CreateCustomerSellerHandler;
use App\Services\Customers\Handlers\CreateCustomerSupervisorHandler;
use App\Services\Customers\Repositories\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class CustomerService
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private CreateCustomerHandler $createCustomerHandler,
        private CreateCustomerSupervisorHandler $createSupervisorHandler,
        private CreateCustomerSellerHandler $createSellerHandler,
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

    public function storeSupervisor(array $data)
    : CustomerSupervisor {
        return $this->createSupervisorHandler->handle($data);
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

    public function getCustomerSupervisors(int $customer_id, array $params = [])
    : Collection {
        return $this->customerRepository->getSupervisors($customer_id, $params);
    }

    public function getCustomerSellers(int $customer_id)
    : Collection {
        return $this->customerRepository->getSellers($customer_id);
    }

    public function updateCustomerSeller(CustomerSeller $customerSeller, array $data)
    : CustomerSeller {
        return $this->customerRepository->updateSellerFromArray($customerSeller, $data);
    }

    public function findCustomerSeller(int $id)
    : ?CustomerSeller {
        return $this->customerRepository->findSeller($id);
    }
}
