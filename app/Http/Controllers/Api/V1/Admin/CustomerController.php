<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Http\Resources\V1\CustomerCollection;
use App\Http\Resources\V1\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CustomerController extends ApiController
{
    protected Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function index()
    : JsonResponse
    {
        $customers = Customer::all();

        return $this->successResponse(
            new CustomerCollection($customers),
            'success',
            __('crud.customers.all'),
        );
    }

    public function store(StoreRequest $request)
    : JsonResponse {
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
        return $this->successResponse(
            new CustomerResource($customer),
            'success',
            __('crud.customers.one'),
        );
    }

    public function update(UpdateRequest $request, Customer $customer)
    : JsonResponse
    {
        $customer->update($request->validated());

        return $this->successResponse(
            new CustomerResource($customer),
            'success',
            __('crud.customers.updated'),
        );
    }

    public function destroy(Customer $customer)
    : JsonResponse
    {
        $canBeDeleted = true; // TODO

        if ($canBeDeleted) {
            $customer->delete();

            return $this->successResponse(
                new CustomerResource($customer),
                'success',
                __('crud.customers.deleted'),
            );
        } else {
            return $this->errorResponse(
                Response::HTTP_OK,
                'error',
                __('crud.customers.not_deleted'),
            );
        }
    }
}
