<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Retailer\StoreRequest;
use App\Http\Resources\V1\RetailerCollection;
use App\Http\Resources\V1\RetailerResource;
use App\Models\Retailer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class RetailerController extends Controller
{
    use AuthorizesRequests;

    public function index()
    : RetailerCollection
    {
        // $this->authorize('viewAny', Retailer::class);

        $retailers = Retailer::query()
            ->with('city')
            ->get();

        return new RetailerCollection($retailers);
    }

    public function store(StoreRequest $request)
    : JsonResponse {
        // $this->authorize('create', Retailer::class);

        return response()->json([
            'item'    => new RetailerResource(Retailer::create($request->validated())),
            'status'  => 'success',
            'message' => 'Торговая сеть создана.',
        ], Response::HTTP_CREATED);
    }

    public function show(Retailer $retailer)
    : RetailerResource {
        // $this->authorize('view', $retailer);

        return new RetailerResource($retailer);
    }

    public function update(StoreRequest $request, Retailer $retailer)
    {
        // $this->authorize('update', $retailer);

        $retailer->update($request->validated());
        return response()->json([
            'item'    => new RetailerResource($retailer),
            'status'  => 'success',
            'message' => 'Торговая сеть обновлена.',
        ], Response::HTTP_OK);
    }

    /*public function destroy(Retailer $directRetailer)
    {
        $this->authorize('delete', $directRetailer);

        $directRetailer->delete();

        return response()->json();
    }*/
}
