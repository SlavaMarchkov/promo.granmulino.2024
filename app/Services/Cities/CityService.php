<?php

declare(strict_types=1);

// 30.09.2024 at 11:28:04
namespace App\Services\Cities;


use App\Models\City;
use App\Services\Cities\Handlers\CreateCityHandler;
use App\Services\Cities\Repositories\CityRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class CityService
{
    public function __construct(
        private CityRepositoryInterface $cityRepository,
        private CreateCityHandler       $createCityHandler,
    )
    {
    }

    public function findCity(City $city)
    : ?City
    {
        return $this->cityRepository->find($city);
    }

    public function getCities()
    : Collection
    {
        return $this->cityRepository->get();
    }

    public function storeCity(array $data)
    : City
    {
        return $this->createCityHandler->handle($data);
    }

    public function updateCity(City $city, array $data)
    : City
    {
        return $this->cityRepository->updateFromArray($city, $data);
    }

    public function deleteCity(City $city)
    : int
    {
        return $this->cityRepository->delete($city);
    }
}
