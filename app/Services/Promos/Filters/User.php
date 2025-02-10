<?php

declare(strict_types=1);

namespace App\Services\Promos\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class User
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('user') && to_boolean(request('user'))) {
            $builder->with('user');
        }

        return $next($builder);
    }
}
