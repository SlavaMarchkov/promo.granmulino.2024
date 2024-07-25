<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    : void
    {
        //
    }

    public function boot()
    : void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)
                ->by($request->user()?->id ? : $request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'Too many attempts.',
                    ], 429);
                });
        });
    }
}
