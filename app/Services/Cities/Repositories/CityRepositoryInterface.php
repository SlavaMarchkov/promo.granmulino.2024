<?php

declare(strict_types=1);

// 30.09.2024 at 11:33:32
namespace App\Services\Cities\Repositories;

use App\Models\City;
use Illuminate\Database\Eloquent\Collection;

interface CityRepositoryInterface
{
    public function find(City $city)
    : ?City;

    public function get()
    : Collection;

    public function createFromArray(array $data)
    : City;

    public function updateFromArray(City $city, array $data)
    : City;

    public function delete(City $city)
    : int;
}
