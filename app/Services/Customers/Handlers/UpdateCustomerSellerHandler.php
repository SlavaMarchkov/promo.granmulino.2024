<?php

declare(strict_types=1);

// 22.11.2024 at 22:11:58
namespace App\Services\Customers\Handlers;


use App\Models\CustomerSeller;
use App\Services\Customers\Repositories\CustomerRepositoryInterface;

final readonly class UpdateCustomerSellerHandler
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
    ) {
    }

    public function handle(CustomerSeller $customerSeller, array $data)
    : CustomerSeller {
        $arr = explode(' ', $data['name']);

        $data['name'] = collect($arr)
            ->map(function ($name) {
                return process_name($name);
            })
            ->reduce(function ($carry, $item) {
                return trim($carry . ' ' . $item);
            });

        return $this->customerRepository->updateSellerFromArray($customerSeller, $data);
    }
}
