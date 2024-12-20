<?php

declare(strict_types=1);

namespace App\Services\Customers\Filters;

use App\Contracts\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

final class CustomerFilter extends AbstractFilter
{

    private const USER_ID          = 'user_id';
    private const REGION           = 'region';
    private const CITY             = 'city';
    private const USER             = 'user';
    private const RETAILERS        = 'retailers';
    private const CUSTOMER_SELLERS = 'customer_sellers';

    public function getCallbacks()
    : array
    {
        return [
            self::USER_ID          => 'user_id',
            self::REGION           => 'region',
            self::CITY             => 'city',
            self::USER             => 'user',
            self::RETAILERS        => 'retailers',
            self::CUSTOMER_SELLERS => 'customer_sellers',
        ];
    }

    public function user_id(Builder $builder, int $value)
    : void {
        $builder->where('user_id', $value);
    }

    public function region(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('region');
        }
    }

    public function city(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('city');
        }
    }

    public function user(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('user');
        }
    }

    public function retailers(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('retailers');
        }
    }

    public function customer_sellers(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('customer_sellers')
                ->orderBy('name')
                ->orderByDesc('is_active');
        }
    }
}
