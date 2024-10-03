<?php

declare(strict_types=1);

// 02.10.2024 at 23:39:38
namespace App\Services\Regions\Repositories;


use App\Models\Region;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class EloquentRegionRepository implements RegionRepositoryInterface
{
    public function find(Region $region)
    : ?Region
    {
        return Region::query()->where('id', $region->id)->first();
    }

    public function get(array $params = [])
    : Collection
    {
        $regionsSql = Region::query();
        $this->applyFilters($regionsSql, $params);
        return $regionsSql->get();
    }

    public function createFromArray(array $data)
    : Region
    {
        return Region::query()->create($data);
    }

    public function updateFromArray(Region $region, array $data)
    : Region
    {
        $region->update($data);
        return $region;
    }

    public function delete(Region $region)
    : int
    {
        $cities_count = $region->cities->count();

        if ($cities_count == 0) {
            $region->delete();
        }

        return $cities_count;
    }

    private function applyFilters(Builder $qb, array $params)
    : void
    {
        $qb->when($params['with_cities'] == true, function ($query) use ($params) {
            return $query->with('cities')->withCount('cities');
        });
    }
}
