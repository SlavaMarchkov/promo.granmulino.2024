<?php

declare(strict_types=1);

// 02.10.2024 at 23:38:21
namespace App\Services\Regions\Handlers;


use App\Models\Region;
use App\Services\Regions\Repositories\RegionRepositoryInterface;

final readonly class UpdateRegionHandler
{
    public function __construct(
        private RegionRepositoryInterface $regionRepository,
    )
    {
    }

    public function handle(Region $region, array $data)
    : Region
    {
        $data['code'] = process_code($data['code']);
        return $this->regionRepository->updateFromArray($region, $data);
    }
}
