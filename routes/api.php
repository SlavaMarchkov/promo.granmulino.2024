<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CityController;
use App\Http\Controllers\Api\V1\RegionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->middleware([
        'throttle:api',
    ])
    ->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])
            ->middleware('auth:sanctum');
    });

Route::prefix('v1')
    ->middleware([
        'throttle:api',
        'auth:sanctum',
    ])
    ->group(function () {
        Route::apiResource('regions', RegionController::class);
        Route::apiResource('cities', CityController::class);
    });
