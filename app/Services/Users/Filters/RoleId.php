<?php

declare(strict_types=1);

namespace App\Services\Users\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class RoleId
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('role_id')) {
            $builder->where('role_id', request('role_id'));
        }

        return $next($builder);
    }
}
