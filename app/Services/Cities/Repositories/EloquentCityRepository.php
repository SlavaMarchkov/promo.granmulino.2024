<?php

declare(strict_types=1);

// 30.09.2024 at 11:31:39
namespace App\Services\Cities\Repositories;


use App\Models\City;
use Illuminate\Database\Eloquent\Collection;

final class EloquentCityRepository implements CityRepositoryInterface
{
    public function find(City $city)
    : ?City
    {
        return City::query()->where('id', $city->id)->first();
    }

    public function get()
    : Collection
    {
        $citiesSql = City::query();
        return $citiesSql->with('region')->get();
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
