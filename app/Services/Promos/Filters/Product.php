<?php

declare(strict_types=1);

namespace App\Services\Promos\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class Product
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('product') && to_boolean(request('product'))) {
            $builder->with('product');
        }

        return $next($builder);
    }
}
