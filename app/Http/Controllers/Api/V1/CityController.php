<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\City\StoreUpdateRequest;
use App\Http\Resources\V1\CityResource;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('region')
            ->orderBy('id', 'desc')
            ->get();
        return CityResource::collection($cities);
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse {
        return response()->json([
            'item'    => new CityResource(City::create($request->validated())),
            'status'  => 'success',
            'message' => 'Город создан.',
        ], Response::HTTP_CREATED);
    }

    public function show(City $city)
    {
        return new CityResource($city);
    }

    public function update(StoreUpdateRequest $request, City $city)
    {
        $city->update($request->validated());

        return new CityResource($city);
    }

    public function destroy(City $city)
    {
        $city->delete();

        return response()->json();
    }
}
