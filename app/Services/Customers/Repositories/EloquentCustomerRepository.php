<?php

declare(strict_types=1);

// 01.10.2024 at 23:14:01
namespace App\Services\Customers\Repositories;

use App\Models\Customer;
use App\Models\CustomerSeller;
use App\Models\CustomerSupervisor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class EloquentCustomerRepository implements CustomerRepositoryInterface
{

    public function find(Customer $customer, array $params = [])
    : ?Customer {
        $customersSql = Customer::query()->where('id', $customer->id);
        $this->applyFilters($customersSql, $params);
        return $customersSql->first();
    }

    public function get(array $params = [])
    : Collection {
        $customersSql = Customer::query();
        $this->applyFilters($customersSql, $params);
        return $customersSql->get();
    }

    public function createFromArray(array $data)
    : Customer {
        return Customer::query()->create($data);
    }

    public function createSupervisorFromArray(array $data)
    : CustomerSupervisor {
        return CustomerSupervisor::query()->create($data);
    }

    public function createSellerFromArray(array $data)
    : CustomerSeller {
        return CustomerSeller::query()->create($data);
    }

    public function updateFromArray(Customer $customer, array $data)
    : Customer {
        $customer->update($data);
        return $customer;
    }

    public function delete(Customer $customer)
    : int {
        // TODO: Проверить, есть ли привязанный менеджер и брифы
        return 1;
        /*$users_count = $customer->user->count();

        if ($users_count == 0) {
            $customer->delete();
        }

        return $users_count;*/
    }

    private function applyFilters(Builder $qb, array $params)
    : void {
        $qb->when(isset($params['user_id']), fn(Builder $query) => $query->where('user_id', (int)$params['user_id']))
            ->when(
                isset($params['region']) && to_boolean($params['region']),
                fn(Builder $query) => $query->with('region'),
            )
            ->when(isset($params['city']) && to_boolean($params['city']), fn(Builder $query) => $query->with('city'))
            ->when(isset($params['user']) && to_boolean($params['user']), fn(Builder $query) => $query->with('user'))
            ->when(
                isset($params['retailers']) && to_boolean($params['retailers']),
                fn(Builder $query) => $query->with('retailers'),
            )
            ->when(
                isset($params['customer_sellers']) && to_boolean($params['customer_sellers']),
                fn(Builder $query) => $query->with('customer_sellers')->orderBy('name')->orderByDesc('is_active'),
            );
    }

    public function getSupervisors(int $customer_id, array $params = [])
    : Collection {
        $supervisorsSql = CustomerSupervisor::query()
            ->where('customer_id', $customer_id)
            ->orderBy('name')->orderByDesc('is_active');
        $this->applySupervisorsFilters($supervisorsSql, $params);
        return $supervisorsSql->get();
    }

    private function applySupervisorsFilters(Builder $qb, array $params)
    : void {
        $qb->when(
            isset($params['sellers']) && to_boolean($params['sellers']),
            fn(Builder $query) => $query->with('sellers')->orderBy('name')->orderByDesc('is_active')
        )
            ->when(
                isset($params['customer']) && to_boolean($params['customer']),
                fn(Builder $query) => $query->with('customer')
            );
    }
}
