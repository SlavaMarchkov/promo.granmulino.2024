<?php

declare(strict_types=1);

// 02.10.2024 at 23:38:21
namespace App\Services\Regions\Handlers;


use App\Models\Region;
use App\Services\Regions\Repositories\RegionRepositoryInterface;

final readonly class CreateRegionHandler
{
    public function __construct(
        private RegionRepositoryInterface $regionRepository,
    )
    {
    }

    public function handle(array $data)
    : Region
    {
        $data['code'] = process_code($data['code']);
        return $this->regionRepository->createFromArray($data);
    }
}
