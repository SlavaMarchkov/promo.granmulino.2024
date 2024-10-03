<?php

declare(strict_types=1);

// 03.10.2024 at 23:09:21
namespace App\Services\Retailers\Repositories;


use App\Models\Retailer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class EloquentRetailerRepository implements RetailerRepositoryInterface
{
    public function find(Retailer $retailer)
    : ?Retailer
    {
        return Retailer::query()->where('id', $retailer->id)->first();
    }

    public function get(array $params = [])
    : Collection
    {
        $retailersSql = Retailer::query();
        $this->applyFilters($retailersSql, $params);
        return $retailersSql->get();
    }

    public function createFromArray(array $data)
    : Retailer
    {
        return Retailer::query()->create($data);
    }

    public function updateFromArray(Retailer $retailer, array $data)
    : Retailer
    {
        $retailer->update($data);
        return $retailer;
    }

    public function delete(Retailer $retailer)
    : int
    {
        // TODO: Проверить наличие брифов и др. зависимостей
        return 1;
        /*$customers_count = $retailer->customer->count();

        if ($customers_count == 0) {
            $retailer->delete();
        }

        return $customers_count;*/
    }

    private function applyFilters(Builder $qb, array $params)
    : void
    {
        $qb->when($params['with_city'] == true, function (Builder $query) {
            return $query->with('city');
        })->when($params['with_customer'] == true, function (Builder $query) {
            return $query->with('customer');
        });
    }
}
