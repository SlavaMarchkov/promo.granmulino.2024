<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Customer\StoreUpdateRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Http\Resources\V1\Customer\CustomerCollection;
use App\Http\Resources\V1\Customer\CustomerResource;
use App\Models\Customer;
use App\Services\Customers\CustomerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CustomerController extends ApiController
{
    use AuthorizesRequests;

    public function __construct(
        private readonly CustomerService $customerService,
    )
    {}

    public function index()
    : JsonResponse
    {
        $customers = $this->customerService->getCustomers([
            'user_id' => auth()->id(),
            ...request()->all()
        ]);

        return $this->successResponse(
            new CustomerCollection($customers),
            'success',
            __('crud.customers.all'),
        );
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse
    {
        return $this->successResponse(
            new CustomerResource(Customer::create($request->validated())),
            'success',
            __('crud.customers.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(Customer $customer)
    : JsonResponse
    {
        $this->authorize('view', $customer);
        $customer = $this->customerService->findCustomer($customer, [
            ...request()->all()
        ]);

        return $this->successResponse(
            new CustomerResource($customer),
            'success',
            __('crud.customers.one'),
        );
    }

    public function update(UpdateRequest $request, Customer $customer)
    : JsonResponse
    {
        $this->authorize('update', $customer);

        $customer->update($request->validated());

        return $this->successResponse(
            new CustomerResource($customer),
            'success',
            __('crud.customers.updated'),
        );
    }
}
