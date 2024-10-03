<?php

declare(strict_types=1);

// 03.10.2024 at 23:10:20
namespace App\Services\Retailers;


use App\Models\Retailer;
use App\Services\Retailers\Handlers\CreateRetailerHandler;
use App\Services\Retailers\Repositories\RetailerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class RetailerService
{
    public function __construct(
        private RetailerRepositoryInterface $retailerRepository,
        private CreateRetailerHandler       $createRetailerHandler,
    )
    {
    }

    public function findRetailer(Retailer $retailer)
    : ?Retailer
    {
        return $this->retailerRepository->find($retailer);
    }

    public function getRetailers(array $params)
    : Collection
    {
        return $this->retailerRepository->get($params);
    }

    public function storeRetailer(array $data)
    : Retailer
    {
        return $this->createRetailerHandler->handle($data);
    }

    public function updateRetailer(Retailer $retailer, array $data)
    : Retailer
    {
        return $this->retailerRepository->updateFromArray($retailer, $data);
    }

    public function deleteRetailer(Retailer $retailer)
    : int
    {
        return $this->retailerRepository->delete($retailer);
    }
}
