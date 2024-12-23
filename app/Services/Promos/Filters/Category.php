<?php

declare(strict_types=1);

namespace App\Services\Promos\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class Category
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('category') && to_boolean(request('category'))) {
            $builder->with('category');
        }

        return $next($builder);
    }
}
