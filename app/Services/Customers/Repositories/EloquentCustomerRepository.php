<?php

declare(strict_types=1);

// 01.10.2024 at 23:14:01
namespace App\Services\Customers\Repositories;

use App\Models\Customer;
use App\Models\CustomerProduct;
use App\Models\CustomerSales;
use App\Models\CustomerSeller;
use App\Services\Customers\Filters\CustomerFilter;
use App\Services\Customers\Filters\CustomerProductFilter;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final readonly class EloquentCustomerRepository implements CustomerRepositoryInterface
{

    /**
     * @throws BindingResolutionException
     */
    public function findCustomer(Customer $customer, array $params = [])
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

    public function getCustomers(array $params = [])
    : Collection {
        $filter = new CustomerFilter($params);
        $customersSql = Customer::filter($filter);
        return $customersSql->get();
    }

    public function createCustomerFromArray(array $data)
    : Customer {
        return Customer::query()->create($data);
    }

    public function createSellerFromArray(array $data)
    : CustomerSeller {
        return CustomerSeller::query()->create($data);
    }

    public function updateCustomerFromArray(Customer $customer, array $data)
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

    public function deleteCustomer(Customer $customer)
    : int {
        $user_id = (int)$customer->user->id;
        $promo_count = DB::scalar('select count(*) as count from promos where customer_id = ?', [$customer->id]);

        if ($user_id === 0 && $promo_count === 0) {
            $customer->delete();
        }

        return $user_id + $promo_count;
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

    /**
     * @throws BindingResolutionException
     */
    public function getProducts(int $customer_id, array $params = [])
    : Collection {
        try {
            $filter = app()->make(CustomerProductFilter::class, ['params' => $params]);
            $productsSql = CustomerProduct::query()
                ->where('customer_id', $customer_id)
                ->filter($filter);
            return $productsSql->get();
        } catch (BindingResolutionException $e) {
            Log::error('Error in CustomerProductFilter: ' . $e->getMessage());
            throw new BindingResolutionException($e->getMessage());
        }
    }

    public function createProductsFromArray(Customer $customer, array $data)
    : Collection {
        foreach ($data['products'] as $product) {
            CustomerProduct::updateOrCreate(
                ['customer_id' => $product['customer_id'], 'product_id' => $product['product_id']],
                $product,
            );
        }
        $customer->fresh();
        return CustomerProduct::query()
            ->where('customer_id', $customer->id)
            ->get();
    }

    public function getSales(array $params = [])
    : Collection {
        $customerSalesSql = CustomerSales::query();
        $this->applyFilters($customerSalesSql, $params);
        return $customerSalesSql->get();
    }

    public function getSalesYears()
    : array
    {
        $years = CustomerSales::select([DB::raw('extract(year FROM sales_date) AS year')])
            ->distinct()
            ->pluck('year')
            ->toArray();

        return !empty($years) ? range(min($years), max($years)) : $years;
    }

    public function createSalesPlanFromArray(Customer $customer, array $data)
    : Collection {
        $customer->sales()->createUpdateOrDelete($data);

        return CustomerSales::query()
            ->with(['customer', 'category'])
            ->where('customer_id', $data['customer_id'])
            ->where('sales_date', $data['sales_date'])
            ->get();
    }

    public function updateSalesPlanFromArray(CustomerSales $sales, array $data)
    : CustomerSales {
        $sales = $this->getSalesPlanById($data['id']);
        unset($data['id']);
        $sales->update($data);
        $sales->fresh();
        return $sales;
    }

    private function getSalesPlanById(int $id)
    : CustomerSales {
        return CustomerSales::query()->where('id', $id)->first();
    }

    private function applyFilters(Builder $qb, array $params)
    : void {
        $user_id = isset($params['user_id']) ? (int)$params['user_id'] : null;
        $customer_id = isset($params['customer_id']) ? (int)$params['customer_id'] : null;
        $year = $params['year'] ?? null;
        $month = $params['month'] ?? null;

        $qb->when($user_id, fn(Builder $query, int $user_id) => $query->where('user_id', $user_id))
            ->when($customer_id, fn(Builder $query, int $customer_id) => $query->where('customer_id', $customer_id))
            ->when($year, fn(Builder $query, string $year) => $query->whereYear('sales_date', $year))
            ->when($month, fn(Builder $query, string $month) => $query->whereMonth('sales_date', $month));
    }
}
