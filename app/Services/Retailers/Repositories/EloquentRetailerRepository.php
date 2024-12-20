<?php

declare(strict_types=1);

// 03.10.2024 at 23:09:21
namespace App\Services\Retailers\Repositories;


use App\Models\Retailer;
use App\Models\User;
use App\Services\Retailers\Filters\RetailerFilter;
use Illuminate\Database\Eloquent\Collection;

final class EloquentRetailerRepository implements RetailerRepositoryInterface
{
    public function find(Retailer $retailer)
    : ?Retailer {
        return Retailer::query()->where('id', $retailer->id)->first();
    }

    public function get(array $params = [])
    : Collection {
        $filter = new RetailerFilter($params);
        $retailersSql = Retailer::filter($filter);
        return $retailersSql->get();
    }

    public function getByUserId(int $user_id)
    : Collection {
        $user = User::query()->where('id', $user_id)->first();
        return $user->retailers;
    }

    public function createFromArray(array $data)
    : Retailer {
        return Retailer::query()->create($data);
    }

    public function updateFromArray(Retailer $retailer, array $data)
    : Retailer
    {
        $retailer->update($data);
        return $retailer;
    }

    public function delete(Retailer $retailer)
    : int {
        // TODO: Проверить наличие брифов и др. зависимостей
        return 1;
        /*$customers_count = $retailer->customer->count();

        if ($customers_count == 0) {
            $retailer->delete();
        }

        return $customers_count;*/
    }
}
