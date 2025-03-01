<?php

declare(strict_types=1);

// 30.09.2024 at 11:31:39
namespace App\Services\Cities\Repositories;


use App\Models\City;
use App\Services\Cities\Filters\CityFilter;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

final class EloquentCityRepository implements CityRepositoryInterface
{

    /**
     * @throws BindingResolutionException
     */
    public function find(City $city, array $params = [])
    : ?City {
        try {
            $filter = app()->make(CityFilter::class, ['params' => $params]);
            $citySql = City::query()
                ->where('id', $city->id)
                ->filter($filter);
            return $citySql->first();
        } catch (BindingResolutionException $e) {
            Log::error('Error in CityFilter: ' . $e->getMessage());
            throw new BindingResolutionException($e->getMessage());
        }
    }

    /**
     * @throws BindingResolutionException
     */
    public function get(array $params = [])
    : Collection
    {
        try {
            $filter = app()->make(CityFilter::class, ['params' => $params]);
            $citiesSql = City::filter($filter);
            return $citiesSql->get();
        } catch (BindingResolutionException $e) {
            Log::error('Error in CityFilter: ' . $e->getMessage());
            throw new BindingResolutionException($e->getMessage());
        }
    }

    public function createFromArray(array $data)
    : City
    {
        return City::query()->create($data);
    }

    public function updateFromArray(City $city, array $data)
    : City
    {
        $city->update($data);
        return $city;
    }

    public function delete(City $city)
    : int
    {
        $customers_count = $city->customers->count();

        if ($customers_count == 0) {
            $city->delete();
        }

        return $customers_count;
    }
}
