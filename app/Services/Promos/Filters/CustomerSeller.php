<?php

declare(strict_types=1);

namespace App\Services\Promos\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class CustomerSeller
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('customer_seller') && to_boolean(request('customer_seller'))) {
            $builder->with('customer_seller');
        }

        return $next($builder);
    }
}
