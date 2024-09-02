<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\City\StoreUpdateRequest;
use App\Http\Resources\V1\CityCollection;
use App\Http\Resources\V1\CityResource;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CityController extends ApiController
{
    protected City $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function index()
    : JsonResponse
    {
        $cities = $this->city->getCityWithRegion();

        return $this->successResponse(
            new CityCollection($cities),
            'success',
            __('crud.cities.all'),
        );
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse {
        return $this->successResponse(
            new CityResource(City::create($request->validated())),
            'success',
            __('crud.cities.created'),
            Response::HTTP_CREATED,
        );
    }

    // TODO: realize
    public function show(City $city)
    : CityResource {
        return new CityResource($city);
    }

    public function update(StoreUpdateRequest $request, City $city)
    : JsonResponse {
        $city->update($request->validated());

        return $this->successResponse(
            new CityResource($city),
            'success',
            __('crud.cities.updated'),
        );
    }

    public function destroy(City $city)
    : JsonResponse {
        $canBeDeleted = false; // TODO: проверить на привязанные города у Customer и Retailer

        if ($canBeDeleted) {
            $city->delete();

            return $this->successResponse(
                new CityResource($city),
                'success',
                __('crud.cities.deleted'),
            );
        } else {
            return $this->errorResponse(
                Response::HTTP_OK,
                'error',
                __('crud.cities.not_deleted'),
            );
        }
    }
}
