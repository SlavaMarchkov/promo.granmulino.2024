<?php

declare(strict_types=1);

// 01.10.2024 at 23:14:01
namespace App\Services\Customers\Repositories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class EloquentCustomerRepository implements CustomerRepositoryInterface
{

    public function find(Customer $customer)
    : ?Customer
    {
        return Customer::query()->where('id', $customer->id)->first();
    }

    public function get(array $params = [])
    : Collection
    {
        $customersSql = Customer::query();
        $this->applyFilters($customersSql, $params);
        return $customersSql->get();
    }

    public function createFromArray(array $data)
    : Customer
    {
        return Customer::query()->create($data);
    }

    public function updateFromArray(Customer $customer, array $data)
    : Customer
    {
        $customer->update($data);
        return $customer;
    }

    public function delete(Customer $customer)
    : int
    {
        // TODO: Проверить, есть ли привязанный менеджер и брифы
        return 1;
        /*$users_count = $customer->user->count();

        if ($users_count == 0) {
            $customer->delete();
        }

        return $users_count;*/
    }

    private function applyFilters(Builder $qb, array $params)
    {
    }
}
