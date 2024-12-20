<?php

declare(strict_types=1);

// 01.10.2024 at 23:14:01
namespace App\Services\Customers\Repositories;

use App\Models\Customer;
use App\Models\CustomerSeller;
use App\Services\Customers\Filters\CustomerFilter;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

final readonly class EloquentCustomerRepository implements CustomerRepositoryInterface
{

    /**
     * @throws BindingResolutionException
     */
    public function find(Customer $customer, array $params = [])
    : ?Customer {
        try {
            $filter = app()->make(CustomerFilter::class, ['params' => $params]);
            $customersSql = Customer::query()
                ->where('id', $customer->id)
                ->filter($filter);
            return $customersSql->first();
        } catch (BindingResolutionException $e) {
            Log::error('Error in CustomerFilter: ' . $e->getMessage());
            throw new BindingResolutionException($e->getMessage());
        }
    }

    public function findSeller(int $id)
    : ?CustomerSeller {
        $customerSeller = CustomerSeller::query()->whereId($id);
        return $customerSeller->first();
    }

    public function get(array $params = [])
    : Collection {
        $filter = new CustomerFilter($params);
        $customersSql = Customer::filter($filter);
        return $customersSql->get();
    }

    public function createFromArray(array $data)
    : Customer {
        return Customer::query()->create($data);
    }

    public function createSellerFromArray(array $data)
    : CustomerSeller {
        return CustomerSeller::query()->create($data);
    }

    public function updateFromArray(Customer $customer, array $data)
    : Customer {
        $customer->update($data);
        $customer->fresh();
        return $customer;
    }

    public function updateSellerFromArray(CustomerSeller $customerSeller, array $data)
    : CustomerSeller {
        $customerSeller->update($data);
        $customerSeller->fresh();
        return $customerSeller;
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

    public function deleteSeller(CustomerSeller $seller)
    : int {
        $sellers_count = CustomerSeller::query()->whereId($seller->id)->count('supervisor_id');

        if ($sellers_count == 0) {
            $seller->delete();
        }

        return $sellers_count;
    }

    public function getSellers(int $customer_id)
    : Collection {
        $sellersSql = CustomerSeller::query()
            ->where('customer_id', $customer_id)
            ->orderBy('name')->orderByDesc('is_active');
        return $sellersSql->get();
    }
}
