<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Region\StoreUpdateRequest;
use App\Http\Resources\V1\RegionCollection;
use App\Http\Resources\V1\RegionResource;
use App\Models\Region;
use App\Services\Regions\RegionService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class RegionController extends ApiController
{
    public function __construct(
        private readonly RegionService $regionService,
    )
    {}

    public function index()
    : JsonResponse
    {
        $regions = $this->regionService->getRegions([
            'with_cities' => true,
        ]);

        return $this->successResponse(
            new RegionCollection($regions),
            'success',
            __('crud.regions.all'),
        );
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse
    {
        $data = $request->validated();
        $region = $this->regionService->storeRegion($data);

        return $this->successResponse(
            new RegionResource($region),
            'success',
            __('crud.regions.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(Region $region)
    : JsonResponse
    {
        $region = $this->regionService->findRegion($region);

        return $this->successResponse(
            new RegionResource($region),
            'success',
            __('crud.regions.one'),
        );
    }

    public function update(StoreUpdateRequest $request, Region $region)
    : JsonResponse
    {
        $data = $request->validated();
        $region = $this->regionService->updateRegion($region, $data);

        return $this->successResponse(
            new RegionResource($region),
            'success',
            __('crud.regions.updated'),
        );
    }

    public function destroy(Region $region)
    : JsonResponse
    {
        $result = $this->regionService->deleteRegion($region);

        return ($result == 0)
            ? $this->successResponse(
                new RegionResource($region),
                'success',
                __('crud.regions.deleted'),
            )
            : $this->errorResponse(
                Response::HTTP_OK,
                'error',
                __('crud.regions.not_deleted'),
            );
    }
}
