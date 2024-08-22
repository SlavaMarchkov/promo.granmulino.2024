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
    public function index()
    : JsonResponse
    {
        $regions = Region::query()
            ->with('cities')
            ->withCount('cities')
            ->get();

        return $this->successResponse(
            new RegionCollection($regions),
            'success',
            'Получена коллекция Регионов.',
        );
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse {
        $region = new RegionResource(Region::create($request->validated()));

        return $this->successResponse(
            $region,
            'success',
            'Регион создан.',
            Response::HTTP_CREATED,
        );
    }

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
                'Получен один Регион.',
            );
        } else {
            return $this->errorResponse(
                Response::HTTP_NOT_FOUND,
                'error',
                'Регион с ID = ' . $region->id . ' не найден!',
            );
        }
    }

    public function update(StoreUpdateRequest $request, Region $region)
    : JsonResponse {
        $region->update($request->validated());

        return $this->successResponse(
            new RegionResource($region),
            'success',
            'Регион обновлён.',
        );
    }

    public function destroy(Region $region)
    : JsonResponse {
        $region->delete();
        return response()->json([
            'message' => 'Регион удалён.',
        ]);
    }
}
