<?php

use App\Http\Controllers\Api\V1\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\V1\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\V1\Admin\CityController as AdminCityController;
use App\Http\Controllers\Api\V1\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Api\V1\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\V1\Admin\RegionController as AdminRegionController;
use App\Http\Controllers\Api\V1\Admin\RetailerController as AdminRetailerController;
use App\Http\Controllers\Api\V1\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\V1\AuthController;
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

Route::prefix('v1/admin')
    ->middleware([
        'throttle:api',
    ])
    ->group(function () {
        Route::get('user', [AdminAuthController::class, 'user'])
            ->middleware('auth:sanctum');
        Route::post('login', [AdminAuthController::class, 'login']);
        Route::post('logout', [AdminAuthController::class, 'logout']);
    });

Route::prefix('v1/admin')
    ->middleware([
        'auth:sanctum',
    ])
    ->group(function () {
        Route::apiResource('regions', AdminRegionController::class);
        Route::apiResource('cities', AdminCityController::class);
        Route::apiResource('categories', AdminCategoryController::class);
        Route::apiResource('products', AdminProductController::class);
        Route::apiResource('customers', AdminCustomerController::class);
        Route::apiResource('retailers', AdminRetailerController::class);
        Route::apiResource('users', AdminUserController::class);
    });

Route::prefix('v1')
    ->middleware([
        'auth:sanctum',
    ])
    ->group(function () {
        Route::apiResource('customers', CustomerController::class);
    });
