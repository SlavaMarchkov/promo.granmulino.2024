<?php

declare(strict_types=1);

// 01.10.2024 at 23:13:02
namespace App\Services\Customers\Repositories;

use App\Models\Customer;
use App\Models\CustomerSales;
use App\Models\CustomerSeller;
use Illuminate\Database\Eloquent\Collection;

interface CustomerRepositoryInterface
{

    public function getCustomers(array $params = [])
    : Collection;

    public function findCustomer(Customer $customer, array $params = [])
    : ?Customer;

    public function createCustomerFromArray(array $data)
    : Customer;

    public function updateCustomerFromArray(Customer $customer, array $data)
    : Customer;

    public function deleteCustomer(Customer $customer)
    : int;

    public function getSellers(int $customer_id)
    : Collection;

    public function findSeller(int $id)
    : ?CustomerSeller;

    public function createSellerFromArray(array $data)
    : CustomerSeller;

    public function updateSellerFromArray(CustomerSeller $customerSeller, array $data)
    : CustomerSeller;

    public function deleteSeller(CustomerSeller $seller)
    : int;

    public function getProducts(int $customer_id, array $params = [])
    : Collection;

    public function createProductsFromArray(Customer $customer, array $data)
    : Collection;

    public function getSales(array $params = [])
    : Collection;

    public function createSalesPlanFromArray(Customer $customer, array $data)
    : void;

    public function updateSalesPlanFromArray(CustomerSales $sales, array $data)
    : CustomerSales;

    public function getSalesYears()
    : array;
}
