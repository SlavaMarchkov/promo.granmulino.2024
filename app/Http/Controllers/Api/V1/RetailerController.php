<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Retailer\StoreRequest;
use App\Http\Resources\V1\RetailerResource;
use App\Models\Retailer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class RetailerController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Retailer::class);

        return RetailerResource::collection(Retailer::all());
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Retailer::class);

        return new RetailerResource(Retailer::create($request->validated()));
    }

    public function show(Retailer $directRetailer)
    {
        $this->authorize('view', $directRetailer);

        return new RetailerResource($directRetailer);
    }

    public function update(StoreRequest $request, Retailer $directRetailer)
    {
        $this->authorize('update', $directRetailer);

        $directRetailer->update($request->validated());

        return new RetailerResource($directRetailer);
    }

    public function destroy(Retailer $directRetailer)
    {
        $this->authorize('delete', $directRetailer);

        $directRetailer->delete();

        return response()->json();
    }
}
