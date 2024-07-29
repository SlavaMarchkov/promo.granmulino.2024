<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\City\StoreRequest;
use App\Http\Requests\City\UpdateRequest;
use App\Http\Resources\V1\CityResource;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CityController extends Controller
{
    public function index()
    {
        $orderColumn = request('order_column', 'id');
        if (!in_array($orderColumn, ['id', 'name', 'region'])) {
            $orderColumn = 'id';
        }

        $orderDirection = request('order_direction', 'desc');
        if (!in_array($orderDirection, ['asc', 'desc'])) {
            $orderDirection = 'desc';
        }

        // TODO
        $cities = City::with('region')
//            ->orderBy($orderColumn, $orderDirection)
            ->orderBy('id', 'desc')
            ->get();

        return CityResource::collection($cities);
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
