<?php

declare(strict_types=1);

namespace App\Services\Retailers\Filters;

use App\Contracts\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

final class RetailerFilter extends AbstractFilter
{

    private const USER_ID  = 'user_id';
    private const CITY     = 'city';
    private const CUSTOMER = 'customer';

    public function getCallbacks()
    : array
    {
        return [
            self::USER_ID  => 'user_id',
            self::CITY     => 'city',
            self::CUSTOMER => 'customer',
        ];
    }

    public function user_id(Builder $builder, int $value)
    : void {
        $builder->where('user_id', $value);
    }

    public function city(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('city');
        }
    }

    public function customer(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('customer');
        }
    }
}
