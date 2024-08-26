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
    : JsonResponse {
        $region = new RegionResource(Region::create($request->validated()));

        return $this->successResponse(
            $region,
            'success',
            __('crud.regions.created'),
            Response::HTTP_CREATED,
        );
    }

    // TODO: how to show one item
    public function show(Region $region)
    : JsonResponse {
        $foundRegion = Region::query()
            ->where('id', '=', $region->id)
            ->with('cities')
            ->withCount('cities')
            ->first();

        if ($foundRegion) {
            return $this->successResponse(
                new RegionResource($foundRegion),
                'success',
                __('crud.regions.one'),
            );
        } else {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'error',
                __('crud.regions.not_found', $region->id),
            );
        }
    }

    public function update(StoreUpdateRequest $request, Region $region)
    : JsonResponse {
        $region->update($request->validated());

        return $this->successResponse(
            new RegionResource($region),
            'success',
            __('crud.regions.updated'),
        );
    }

    // TODO: check
    public function destroy(Region $region)
    : JsonResponse {
        $region->delete();

        return $this->successResponse(
            new RegionResource($region),
            'success',
            __('crud.regions.deleted'),
        );
    }
}
