<?php

use App\Http\Controllers\Api\V1\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\CityController;
use App\Http\Controllers\Api\V1\Admin\ProductController;
use App\Http\Controllers\Api\V1\Admin\RegionController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
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
        Route::apiResource('regions', RegionController::class);
        Route::apiResource('cities', CityController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('products', ProductController::class);
    });

Route::prefix('v1')
    ->middleware([
        'auth:sanctum',
    ])
    ->group(function () {
        Route::resource('users', UserController::class);
    });
