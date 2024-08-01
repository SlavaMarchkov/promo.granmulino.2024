<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Resources\V1\CustomerResource;
use App\Models\Customer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class CustomerController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Customer::class);

        return CustomerResource::collection(Customer::all());
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Customer::class);

        return new CustomerResource(Customer::create($request->validated()));
    }

    public function show(Customer $customer)
    {
        $this->authorize('view', $customer);

        return new CustomerResource($customer);
    }

    public function update(StoreRequest $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        $customer->update($request->validated());

        return new CustomerResource($customer);
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->delete();

        return response()->json();
    }
}
