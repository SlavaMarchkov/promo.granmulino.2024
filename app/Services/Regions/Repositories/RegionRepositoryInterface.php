<?php

declare(strict_types=1);

// 02.10.2024 at 23:38:51
namespace App\Services\Regions\Repositories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Collection;

interface RegionRepositoryInterface
{
    public function find(Region $region)
    : ?Region;

    public function get(array $params = [])
    : Collection;

    public function createFromArray(array $data)
    : Region;

    public function updateFromArray(Region $region, array $data)
    : Region;

    public function delete(Region $region)
    : void;
}
