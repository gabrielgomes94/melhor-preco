<?php

use App\Http\Controllers\Front\Pricing\Price\UpdateController;
use App\Http\Controllers\Front\Pricing\PriceList\IndexController;
use App\Http\Controllers\Front\Pricing\PriceList\ByStore\ExportController as ByStoreExportController;
use App\Http\Controllers\Front\Pricing\PriceList\ByStore\ShowController as ByStoreShowController;
use App\Http\Controllers\Front\Pricing\PriceList\Custom\CreateController;
use App\Http\Controllers\Front\Pricing\PriceList\Custom\ExportController as CustomExportController;
use App\Http\Controllers\Front\Pricing\PriceList\Custom\ListController;
use App\Http\Controllers\Front\Pricing\PriceList\Custom\ShowController as CustomShowController;
use App\Http\Controllers\Front\Pricing\Product\RemoveController;
use App\Http\Controllers\Front\Pricing\Product\ShowController as ProductShowController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('pricing')
        ->name('pricing')
        ->group(function () {
            Route::get('/create', [CreateController::class, 'create'])->name('.create');
            Route::post('{id}/export', [CustomExportController::class, 'export'])->name('.export');

            Route::prefix('/price_list')
                ->name('.priceList')
                ->group(function () {
                    Route::get('/', [IndexController::class, 'index'])->name('.index');

                    Route::prefix('/custom')->name('.custom')->group(function () {
                        Route::get('/', [ListController::class, 'list'])->name('.list');
                        Route::get('/create', [CreateController::class, 'create'])->name('.create');
                        Route::get('/{id}', [CustomShowController::class, 'show'])->name('.show');
                        Route::get('/{price_list_id}/show/{product_id}', [ProductShowController::class, 'show'])
                            ->name('.product.show');
                    });

                    Route::get('/{store}', [ByStoreShowController::class, 'show'])->name('.byStore');
                });

            Route::prefix('/{store}/products')
                ->name('.products')
                ->group(function () {
                    Route::get('/{product_id}', [ProductShowController::class, 'showByStore'])->name('.showByStore');
                    Route::post('/export', [ByStoreExportController::class, 'export'])->name('.export');
                });

            Route::prefix('/products')
                ->name('.products')
                ->group(function () {
                    Route::get('/{product_id}', [ProductShowController::class, 'show'])->name('.show');
                    Route::delete('/{product_id}', [RemoveController::class, 'remove'])->name('.remove');

                    Route::prefix('/{product_id}/price')
                        ->name('.prices')
                        ->group(function () {
                            Route::put('/{price_id}', [UpdateController::class, 'update'])->name('.update');
                        });
                });

            Route::prefix('campaigns')->name('.campaigns')->group(function () {
                Route::post('/store', [CreateController::class, 'store'])->name('.store');
            });
        });
});
