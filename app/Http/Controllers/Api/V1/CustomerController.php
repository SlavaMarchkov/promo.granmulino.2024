<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Http\Resources\V1\CustomerCollection;
use App\Http\Resources\V1\CustomerResource;
use App\Models\Customer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CustomerController extends Controller
{
    use AuthorizesRequests;

    public function index()
    : CustomerCollection
    {
        return new CustomerCollection(Customer::all());
    }

    public function store(StoreRequest $request)
    : JsonResponse {
        return response()->json([
            'item'    => new CustomerResource(Customer::create($request->validated())),
            'status'  => 'success',
            'message' => 'Контрагент создан.',
        ], Response::HTTP_CREATED);
    }

    public function show(Customer $customer)
    : CustomerResource
    {
        return new CustomerResource($customer);
    }

    public function update(UpdateRequest $request, Customer $customer)
    : JsonResponse {
        dd($request->validated());
        $customer->update($request->validated());
        return response()->json([
            'item'    => new CustomerResource($customer),
            'status'  => 'success',
            'message' => 'Контрагент обновлён.',
        ], Response::HTTP_OK);
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->delete();

        return response()->json();
    }
}
