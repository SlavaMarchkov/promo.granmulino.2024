<?php

use App\Http\Controllers\Api\V1\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\V1\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\V1\Admin\CityController as AdminCityController;
use App\Http\Controllers\Api\V1\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Api\V1\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\V1\Admin\RegionController as AdminRegionController;
use App\Http\Controllers\Api\V1\Admin\RetailerController as AdminRetailerController;
use App\Http\Controllers\Api\V1\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\V1\Manager\AuthController;
use App\Http\Controllers\Api\V1\Manager\CustomerController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->middleware([
        'throttle:api',
    ])
    ->group(function () {
        Route::get('user', [AuthController::class, 'user'])
            ->middleware('auth:sanctum');
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
    });

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group([
        'prefix'     => 'v1/admin',
        'middleware' => 'throttle:api',
    ], function () {
        Route::get('user', [AdminAuthController::class, 'user']);
        Route::post('login', [AdminAuthController::class, 'login'])
            ->withoutMiddleware('auth:sanctum');
        Route::post('logout', [AdminAuthController::class, 'logout']);
        Route::apiResources([
            'regions'    => AdminRegionController::class,
            'cities'     => AdminCityController::class,
            'categories' => AdminCategoryController::class,
            'products'   => AdminProductController::class,
            'customers'  => AdminCustomerController::class,
            'retailers'  => AdminRetailerController::class,
            'users'      => AdminUserController::class,
        ]);
    });
    Route::group([
        'prefix' => 'v1',
    ], function () {
        Route::apiResources([
            'customers' => CustomerController::class,
        ]);
    });
});
