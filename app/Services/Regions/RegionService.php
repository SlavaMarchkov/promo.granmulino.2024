<?php

declare(strict_types=1);

// 02.10.2024 at 23:37:50
namespace App\Services\Regions;


use App\Models\Region;
use App\Services\Regions\Handlers\CreateRegionHandler;
use App\Services\Regions\Repositories\RegionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class RegionService
{
    public function __construct(
        private RegionRepositoryInterface $regionRepository,
        private CreateRegionHandler       $createRegionHandler,
    )
    {
    }

    public function findRegion(Region $region)
    : ?Region
    {
        return $this->regionRepository->find($region);
    }

    public function getRegions(array $params)
    : Collection
    {
        return $this->regionRepository->get($params);
    }

    public function storeRegion(array $data)
    : Region
    {
        return $this->createRegionHandler->handle($data);
    }

    public function updateRegion(Region $region, array $data)
    : Region
    {
        return $this->regionRepository->updateFromArray($region, $data);
    }

    public function deleteRegion(Region $region)
    {
        return $this->regionRepository->delete($region);
    }
}
