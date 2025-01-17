<?php

declare(strict_types=1);

// 01.10.2024 at 23:13:02
namespace App\Services\Customers\Repositories;

use App\Models\Customer;
use App\Models\CustomerSeller;
use Illuminate\Database\Eloquent\Collection;

interface CustomerRepositoryInterface
{
    public function find(Customer $customer, array $params = [])
    : ?Customer;

    public function findSeller(int $id)
    : ?CustomerSeller;

    public function get(array $params = [])
    : Collection;

    public function createFromArray(array $data)
    : Customer;

    public function updateFromArray(Customer $customer, array $data)
    : Customer;

    public function delete(Customer $customer)
    : int;

    public function deleteSeller(CustomerSeller $seller)
    : int;

    public function getSellers(int $customer_id)
    : Collection;

    public function getProducts(int $customer_id, array $params = [])
    : Collection;

    public function createSellerFromArray(array $data)
    : CustomerSeller;

    public function updateSellerFromArray(CustomerSeller $customerSeller, array $data)
    : CustomerSeller;

    public function createProductsFromArray(Customer $customer, array $data)
    : Collection;
}
