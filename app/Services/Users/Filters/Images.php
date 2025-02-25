<?php

declare(strict_types=1);

namespace App\Services\Users\Filters;

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
