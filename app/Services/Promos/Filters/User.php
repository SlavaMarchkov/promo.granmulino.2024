<?php

declare(strict_types=1);

namespace App\Services\Promos\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class User
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('user_id')) {
            $builder->where('user_id', (int)request('user_id'));
        }

        return $next($builder);
    }
}
