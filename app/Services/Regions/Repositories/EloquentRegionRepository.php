<?php

declare(strict_types=1);

// 02.10.2024 at 23:39:38
namespace App\Services\Regions\Repositories;


use App\Models\Region;
use App\Services\Regions\Filters\RegionFilter;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

final class EloquentRegionRepository implements RegionRepositoryInterface
{

    /**
     * @throws BindingResolutionException
     */
    public function find(Region $region, array $params = [])
    : ?Region {
        try {
            $filter = app()->make(RegionFilter::class, ['params' => $params]);
            $regionSql = Region::query()
                ->where('id', $region->id)
                ->filter($filter);
            return $regionSql->first();
        } catch (BindingResolutionException $e) {
            Log::error('Error in RegionFilter: ' . $e->getMessage());
            throw new BindingResolutionException($e->getMessage());
        }
    }

    /**
     * @throws BindingResolutionException
     */
    public function get(array $params = [])
    : Collection {
        try {
            $filter = app()->make(RegionFilter::class, ['params' => $params]);
            $regionsSql = Region::query()->filter($filter);
            return $regionsSql->get();
        } catch (BindingResolutionException $e) {
            Log::error('Error in RegionFilter: ' . $e->getMessage());
            throw new BindingResolutionException($e->getMessage());
        }
    }

    public function createFromArray(array $data)
    : Region {
        return Region::query()->create($data);
    }

    public function updateFromArray(Region $region, array $data)
    : Region {
        $region->update($data);
        return $region;
    }

    public function delete(Region $region)
    : int {
        $cities_count = $region->cities->count();

        if ($cities_count == 0) {
            $region->delete();
        }

        return $cities_count;
    }
}
