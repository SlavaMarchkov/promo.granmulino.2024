<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Region\StoreUpdateRequest;
use App\Http\Resources\V1\RegionCollection;
use App\Http\Resources\V1\RegionResource;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class RegionController extends ApiController
{
    protected Region $region;

    public function __construct(Region $region)
    {
        $this->region = $region;
    }

    public function index()
    : JsonResponse
    {
        $regions = $this->region->getRegionsWithCities();

        return $this->successResponse(
            new RegionCollection($regions),
            'success',
            __('crud.regions.all'),
        );
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse
    {
        return $this->successResponse(
            new RegionResource(Region::create($request->validated())),
            'success',
            __('crud.regions.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(Region $region)
    : JsonResponse
    {
        return $this->successResponse(
            new RegionResource($region),
            'success',
            __('crud.regions.one'),
        );
    }

    public function update(StoreUpdateRequest $request, Region $region)
    : JsonResponse
    {
        $region->update($request->validated());

        return $this->successResponse(
            new RegionResource($region),
            'success',
            __('crud.regions.updated'),
        );
    }

    public function destroy(Region $region)
    : JsonResponse
    {
        $canBeDeleted = false; // TODO: проверить на кол-во городов в регионе и у Customer

        if ($canBeDeleted) {
            $region->delete();

            return $this->successResponse(
                new RegionResource($region),
                'success',
                __('crud.regions.deleted'),
            );
        } else {
            return $this->errorResponse(
                Response::HTTP_OK,
                'error',
                __('crud.regions.not_deleted'),
            );
        }
    }
}
