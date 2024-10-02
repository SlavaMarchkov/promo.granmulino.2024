<?php

declare(strict_types=1);

// 01.10.2024 at 23:13:02
namespace App\Services\Customers\Repositories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;

interface CustomerRepositoryInterface
{
    public function find(Customer $customer)
    : ?Customer;

    public function get(array $params = [])
    : Collection;

    public function createFromArray(array $data)
    : Customer;

    public function updateFromArray(Customer $customer, array $data)
    : Customer;

    public function delete(Customer $customer)
    : void;
}
