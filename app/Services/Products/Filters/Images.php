<?php

declare(strict_types=1);

// 26.03.2025 at 12:06:39
namespace App\Services\Products\Filters;


use Closure;
use Illuminate\Database\Eloquent\Builder;

final class Images
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('images') && to_boolean(request('images'))) {
            $builder->with('images');
        }

        return $next($builder);
    }
}
