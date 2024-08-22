<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\City\StoreRequest;
use App\Http\Requests\City\UpdateRequest;
use App\Http\Resources\V1\CityCollection;
use App\Http\Resources\V1\CityResource;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CityController extends ApiController
{
    public function index()
    : JsonResponse
    {
        $cities = City::query()
            ->with('region')
            ->get();

        return $this->successResponse(
            new CityCollection($cities),
            'success',
            __('crud.cities.all'),
        );
    }

    public function store(StoreRequest $request)
    : JsonResponse {
        $city = new CityResource(City::create($request->validated()));

        return $this->successResponse(
            $city,
            'success',
            __('crud.cities.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(City $city)
    : CityResource {
        return new CityResource($city);
    }

    public function update(UpdateRequest $request, City $city)
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
        $city->delete();

        return response()->json([
            'message' => __('crud.cities.deleted'),
        ]);
    }
}
