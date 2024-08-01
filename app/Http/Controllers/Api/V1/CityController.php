<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\City\StoreRequest;
use App\Http\Requests\City\UpdateRequest;
use App\Http\Resources\V1\CityCollection;
use App\Http\Resources\V1\CityResource;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CityController extends Controller
{
    public function index()
    : CityCollection
    {
        $cities = City::with('region')->get();
        return new CityCollection($cities);
    }

    public function store(StoreRequest $request)
    : JsonResponse {
        return response()->json([
            'item'    => new CityResource(City::create($request->validated())),
            'status'  => 'success',
            'message' => 'Город создан.',
        ], Response::HTTP_CREATED);
    }

    public function show(City $city)
    : CityResource {
        return new CityResource($city);
    }

    public function update(UpdateRequest $request, City $city)
    : JsonResponse {
        $city->update($request->validated());
        return response()->json([
            'item'    => new CityResource($city),
            'status'  => 'success',
            'message' => 'Город обновлён.',
        ], Response::HTTP_OK);
    }

    public function destroy(City $city)
    {
        $city->delete();

        return response()->json();
    }
}
