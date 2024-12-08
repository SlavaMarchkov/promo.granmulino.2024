<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Customer\StoreUpdateRequest;
use App\Http\Resources\V1\Customer\CustomerCollection;
use App\Http\Resources\V1\Customer\CustomerResource;
use App\Models\Customer;
use App\Services\Customers\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

// TODO: make Abilities
final class CustomerController extends ApiController
{
    public function __construct(
        private readonly CustomerService $customerService,
    )
    {
    }

    public function index()
    : JsonResponse
    {
        $key = 'customers-list-admin';
        // Cache::forget($key);

        if (!$customers = Cache::get($key)) {
            $customers = $this->customerService->getCustomers([...request()->all()]);
            Cache::put($key, $customers, now()->addDay());
        }

        return $this->successResponse(
            new CustomerCollection($customers),
            'success',
            __('crud.customers.all'),
        );
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse
    {
        $data = $request->validated();
        $customer = $this->customerService->storeCustomer($data);

        return $this->successResponse(
            new CustomerResource($customer),
            'success',
            __('crud.customers.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(Customer $customer)
    : JsonResponse
    {
        $customer = $this->customerService->findCustomer($customer);

        return $this->successResponse(
            new CustomerResource($customer),
            'success',
            __('crud.customers.one'),
        );
    }

    public function update(StoreUpdateRequest $request, Customer $customer)
    : JsonResponse
    {
        $data = $request->validated();
        $customer = $this->customerService->updateCustomer($customer, $data);

        return $this->successResponse(
            new CustomerResource($customer),
            'success',
            __('crud.customers.updated'),
        );
    }

    public function destroy(Customer $customer)
    : JsonResponse
    {
        $result = $this->customerService->deleteCustomer($customer);

        return ($result == 0)
            ? $this->successResponse(
                new CustomerResource($customer),
                'success',
                __('crud.customers.deleted'),
            )
            : $this->errorResponse(
                Response::HTTP_OK,
                'error',
                __('crud.customers.not_deleted'),
            );
    }
}
