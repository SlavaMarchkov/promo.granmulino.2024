<?php

declare(strict_types=1);

// 08.01.2025 at 20:35:05
namespace App\Services\Customers\Filters;


use App\Contracts\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

final class CustomerProductFilter extends AbstractFilter
{

    private const CUSTOMER = 'customer';
    private const CATEGORY = 'category';
    private const PRODUCT  = 'product';

    public function getCallbacks()
    : array
    {
        return [
            self::CUSTOMER => 'customer',
            self::CATEGORY => 'category',
            self::PRODUCT  => 'product',
        ];
    }

    public function customer(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('customer');
        }
    }

    public function category(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('category');
        }
    }

    public function product(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('product');
        }
    }
}
