<?php

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Controllers\Api\V1\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\V1\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\V1\Admin\CityController as AdminCityController;
use App\Http\Controllers\Api\V1\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Api\V1\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\V1\Admin\PromoController as AdminPromoController;
use App\Http\Controllers\Api\V1\Admin\RegionController as AdminRegionController;
use App\Http\Controllers\Api\V1\Admin\RetailerController as AdminRetailerController;
use App\Http\Controllers\Api\V1\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\V1\ImageController;
use App\Http\Controllers\Api\V1\Manager\AuthController;
use App\Http\Controllers\Api\V1\Manager\CategoryController;
use App\Http\Controllers\Api\V1\Manager\ChannelController;
use App\Http\Controllers\Api\V1\Manager\CityController;
use App\Http\Controllers\Api\V1\Manager\CustomerController;
use App\Http\Controllers\Api\V1\Manager\CustomerProductController;
use App\Http\Controllers\Api\V1\Manager\CustomerSalesController;
use App\Http\Controllers\Api\V1\Manager\CustomerSellerController;
use App\Http\Controllers\Api\V1\Manager\ProductController;
use App\Http\Controllers\Api\V1\Manager\PromoController;
use App\Http\Controllers\Api\V1\Manager\PromoMarkController;
use App\Http\Controllers\Api\V1\Manager\PromoProductController;
use App\Http\Controllers\Api\V1\Manager\PromoSellerController;
use App\Http\Controllers\Api\V1\Manager\RegionController;
use App\Http\Controllers\Api\V1\Manager\RetailerController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group([
        'prefix'     => 'v1/admin',
        'middleware' => ['throttle:api', 'admin'],
        'as'         => 'admin.',
    ], function () {
        Route::get('user', [AdminAuthController::class, 'user'])
            ->name('user');
        Route::post('login', [AdminAuthController::class, 'login'])
            ->name('login')
            ->withoutMiddleware(['auth:sanctum', 'admin']);
        Route::post('logout', [AdminAuthController::class, 'logout'])
            ->name('logout');

        Route::get('promos/{promo}/print', [AdminPromoController::class, 'print']);

        Route::apiResources([
            'administrators' => AdminController::class,
            'cities'         => AdminCityController::class,
            'categories'     => AdminCategoryController::class,
            'customers'      => AdminCustomerController::class,
            'products'       => AdminProductController::class,
            'promos'         => AdminPromoController::class,
            'regions'        => AdminRegionController::class,
            'retailers'      => AdminRetailerController::class,
            'users'          => AdminUserController::class,
        ]);
    });
    Route::group([
        'prefix'     => 'v1',
        'middleware' => 'throttle:api',
        'as'         => 'manager.',
    ], function () {
        Route::get('user', [AuthController::class, 'user'])
            ->name('user');
        Route::post('login', [AuthController::class, 'login'])
            ->name('login')
            ->withoutMiddleware('auth:sanctum');
        Route::post('logout', [AuthController::class, 'logout'])
            ->name('logout');

        Route::get('categories', [CategoryController::class, 'index'])->name('categories');
        Route::get('channels', [ChannelController::class, 'index'])->name('channels');
        Route::get('cities', [CityController::class, 'index'])->name('cities');
        Route::get('products', [ProductController::class, 'index'])->name('products');
        Route::get('regions', [RegionController::class, 'index'])->name('regions');
        Route::get('sales', [CustomerSalesController::class, 'index'])->name('sales');

        Route::post('product-images/{product}', [ImageController::class, 'uploadProductImages'])
            ->name('product.upload-images');
        Route::post('user-images/{user}', [ImageController::class, 'uploadUserImages'])
            ->name('user.upload-images');

        Route::put('promos/{promo}/marks/{mark}', [PromoMarkController::class, 'update'])
            ->name('promos.marks.update');
        Route::get('promos/getPromoYears', [PromoController::class, 'getPromoYears'])
            ->name('promos.getPromoYears');
        Route::get('sales/getSalesYears', [CustomerSalesController::class, 'getSalesYears'])
            ->name('sales.getSalesYears');

        Route::apiResources([
            'promos'             => PromoController::class,
            'retailers'          => RetailerController::class,
            'customers'          => CustomerController::class,
            'customers.products' => CustomerProductController::class,
            'customers.sales'    => CustomerSalesController::class,
            'customers.sellers'  => CustomerSellerController::class,
            'promos.products'    => PromoProductController::class,
            'promos.sellers'     => PromoSellerController::class,
        ]);
    });
});
