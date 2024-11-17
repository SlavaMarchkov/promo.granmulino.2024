<?php

declare(strict_types=1);

// 07.11.2024 at 17:13:54
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Resources\V1\City\CityCollection;
use App\Services\Cities\CityService;
use Illuminate\Http\JsonResponse;

final class CityController extends ApiController
{
    public function __construct(
        private readonly CityService $cityService,
    )
    {}

    public function index()
    : JsonResponse
    {
        $cities = $this->cityService->getCities();

        return $this->successResponse(
            new CityCollection($cities),
            'success',
            __('crud.cities.all'),
        );
    }
}
