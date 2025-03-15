<?php

declare(strict_types=1);

// 13.03.2025 at 13:20:19
namespace App\Providers;

use App\Support\Macros\CreateUpdateOrDelete;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\ServiceProvider;

class HasManyServiceProvider extends ServiceProvider
{
    public function register()
    : void
    {
    }

    public function boot()
    : void
    {
        HasMany::macro('createUpdateOrDelete', function (iterable $array) {
            /** @var HasMany $hasMany */
            $hasMany = $this;
            return (new CreateUpdateOrDelete($hasMany, $array))();
        });
    }
}
