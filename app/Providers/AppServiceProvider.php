<?php

namespace App\Providers;

use App\Services\Categories\Repositories\CategoryRepositoryInterface;
use App\Services\Categories\Repositories\EloquentCategoryRepository;
use App\Services\Cities\Repositories\CityRepositoryInterface;
use App\Services\Cities\Repositories\EloquentCityRepository;
use App\Services\Customers\Repositories\CustomerRepositoryInterface;
use App\Services\Customers\Repositories\EloquentCustomerRepository;
use App\Services\Products\Repositories\EloquentProductRepository;
use App\Services\Products\Repositories\ProductRepositoryInterface;
use App\Services\Promos\Repositories\EloquentPromoRepository;
use App\Services\Promos\Repositories\PromoRepositoryInterface;
use App\Services\Regions\Repositories\EloquentRegionRepository;
use App\Services\Regions\Repositories\RegionRepositoryInterface;
use App\Services\Retailers\Repositories\EloquentRetailerRepository;
use App\Services\Retailers\Repositories\RetailerRepositoryInterface;
use App\Services\Users\Repositories\EloquentUserRepository;
use App\Services\Users\Repositories\UserRepositoryInterface;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    : void
    {
        $this->registerBindings();
    }

    public function boot()
    : void
    {
        $this->bootRateLimiter();
        $this->bootBindingEvents();
    }

    private function registerBindings()
    : void
    {
        $this->registerSMSBindings();

        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class,
        );
        $this->app->bind(
            CategoryRepositoryInterface::class,
            EloquentCategoryRepository::class,
        );
        $this->app->bind(
            CityRepositoryInterface::class,
            EloquentCityRepository::class,
        );
        $this->app->bind(
            ProductRepositoryInterface::class,
            EloquentProductRepository::class,
        );
        $this->app->bind(
            CustomerRepositoryInterface::class,
            EloquentCustomerRepository::class,
        );
        $this->app->bind(
            RegionRepositoryInterface::class,
            EloquentRegionRepository::class,
        );
        $this->app->bind(
            RetailerRepositoryInterface::class,
            EloquentRetailerRepository::class,
        );
        $this->app->bind(
            PromoRepositoryInterface::class,
            EloquentPromoRepository::class,
        );
    }

    /**
     * @return void
     */
    private function bootRateLimiter()
    : void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)
                ->by($request->user()?->id ?: $request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'Too many attempts.',
                    ], 429);
                });
        });
    }

    private function registerSMSBindings()
    {
        // B2BSMS
        // SMSAero
        // SMSRU
        // FlySMS
    }

    private function bootBindingEvents()
    {
        // logging
        // $this->app->resolving();
    }
}
