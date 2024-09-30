<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\City\StoreUpdateRequest;
use App\Http\Resources\V1\CityCollection;
use App\Http\Resources\V1\CityResource;
use App\Models\City;
use App\Services\Cities\CityService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CityController extends ApiController
{
    public function __construct(
        private readonly CityService $cityService,
    )
    {
    }

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

    public function store(StoreUpdateRequest $request)
    : JsonResponse
    {
        $data = $request->validated();
        $city = $this->cityService->storeCity($data);

        return $this->successResponse(
            new CityResource($city),
            'success',
            __('crud.cities.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(City $city)
    : JsonResponse
    {
        $city = $this->cityService->findCity($city);

        return $this->successResponse(
            new CityResource($city),
            'success',
            __('crud.cities.one'),
        );
    }

    public function update(StoreUpdateRequest $request, City $city)
    : JsonResponse
    {
        $data = $request->validated();
        $city = $this->cityService->updateCity($city, $data);

        return $this->successResponse(
            new CityResource($city),
            'success',
            __('crud.cities.updated'),
        );
    }

    public function destroy(City $city)
    : JsonResponse
    {
        $result = $this->cityService->deleteCity($city);

        return ($result === null)
            ? $this->successResponse(
                new CityResource($city),
                'success',
                __('crud.cities.deleted'),
            )
            : $this->errorResponse(
                Response::HTTP_OK,
                'error',
                __('crud.cities.not_deleted'),
            );
    }
}
