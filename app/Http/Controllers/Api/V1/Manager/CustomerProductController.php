<?php

declare(strict_types=1);

// 05.01.2025 at 19:22:49
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Customer\CustomerProductRequest;
use App\Http\Resources\V1\Customer\CustomerProductCollection;
use App\Models\Customer;
use App\Models\CustomerProduct;
use App\Services\Customers\CustomerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CustomerProductController extends ApiController
{
    use AuthorizesRequests;

    public function __construct(
        private readonly CustomerService $customerService,
    ) {
    }

    public function index(Customer $customer)
    : JsonResponse {
        $this->authorize('viewAny', [CustomerProduct::class, $customer]);

        $products = $this->customerService->getCustomerProducts(
            $customer->id,
            [
                'category' => true,
                'product'  => true,
            ],
        );

        return $this->successResponse(
            new CustomerProductCollection($products),
            'success',
            __('crud.products.all'),
        );
    }

    public function store(CustomerProductRequest $request, Customer $customer)
    : JsonResponse {
        $this->authorize('create', [
            CustomerProduct::class,
            $request->get('0')['customer_id'],
            $customer->id,
        ]);

        $products = $request->validated();

        $customer_products = $this->customerService->storeCustomerProducts($customer, $products);

        return $this->successResponse(
            new CustomerProductCollection($customer_products),
            'success',
            __('crud.customers.updated'),
            Response::HTTP_CREATED,
        );
    }
}
