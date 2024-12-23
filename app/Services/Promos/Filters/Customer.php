<?php

declare(strict_types=1);

namespace App\Services\Promos\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class Customer
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('customer') && to_boolean(request('customer'))) {
            $builder->with('customer');
        }

        return $next($builder);
    }
}
