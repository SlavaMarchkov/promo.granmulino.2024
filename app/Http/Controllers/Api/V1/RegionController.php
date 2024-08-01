<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Region\StoreUpdateRequest;
use App\Http\Resources\V1\RegionCollection;
use App\Http\Resources\V1\RegionResource;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class RegionController extends Controller
{
    public function index()
    : RegionCollection
    {
        $regions = Region::with('cities')->get();
        return new RegionCollection($regions);
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse {
        return response()->json([
            'item'    => new RegionResource(Region::create($request->validated())),
            'status'  => 'success',
            'message' => 'Регион создан.',
        ], Response::HTTP_CREATED);
    }

    public function show(Region $region)
    : RegionResource {
        return new RegionResource($region);
    }

    public function update(StoreUpdateRequest $request, Region $region)
    : JsonResponse {
        $region->update($request->validated());
        return response()->json([
            'item'    => new RegionResource($region),
            'status'  => 'success',
            'message' => 'Регион обновлён.',
        ], Response::HTTP_OK);
    }

    public function destroy(Region $region)
    : JsonResponse {
        $region->delete();
        return response()->json([
            'message' => 'Регион удалён.',
        ]);
    }
}
