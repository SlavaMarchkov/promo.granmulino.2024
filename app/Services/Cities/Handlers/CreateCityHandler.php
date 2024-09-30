<?php

declare(strict_types=1);

// 30.09.2024 at 11:36:40
namespace App\Services\Cities\Handlers;


use App\Models\City;
use App\Services\Cities\Repositories\CityRepositoryInterface;

final readonly class CreateCityHandler
{
    public function __construct(
        private CityRepositoryInterface $cityRepository,
    )
    {
    }

    public function handle(array $data)
    : City
    {
        return $this->cityRepository->createFromArray($data);
    }
}
