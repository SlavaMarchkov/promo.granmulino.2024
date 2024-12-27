<?php

declare(strict_types=1);

namespace App\Services\Promos\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class PromoProducts
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('promo_products') && to_boolean(request('promo_products'))) {
            $builder->with('promo_products')->withCount('promo_products');
        }

        return $next($builder);
    }
}
