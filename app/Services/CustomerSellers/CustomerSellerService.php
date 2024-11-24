<?php

declare(strict_types=1);

// 15.11.2024 at 18:02:57
namespace App\Services\CustomerSellers;


use App\Models\CustomerSeller;
use App\Services\CustomerSellers\Handlers\CreateCustomerSellerHandler;
use App\Services\CustomerSellers\Repositories\CustomerSellerRepositoryInterface;

final readonly class CustomerSellerService
{
    public function __construct(
        private CustomerSellerRepositoryInterface $customerSellerRepository,
        private CreateCustomerSellerHandler $createCustomerSellerHandler,
    )
    {
    }

    public function findCustomerSeller(CustomerSeller $customerSeller)
    : ?CustomerSeller {
        return $this->customerSellerRepository->find($customerSeller);
    }

}
