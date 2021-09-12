<?php

use App\Http\Controllers\Front\Pricing\Price\UpdateController;
use App\Http\Controllers\Front\Pricing\PriceList\IndexController;
use App\Http\Controllers\Front\Pricing\PriceList\ByStore\ExportController as ByStoreExportController;
use App\Http\Controllers\Front\Pricing\PriceList\ByStore\ShowController as ByStoreShowController;
use App\Http\Controllers\Front\Pricing\PriceLog\PriceLogController;
use App\Http\Controllers\Front\Pricing\Product\ShowController as ProductShowController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('pricing')
        ->name('pricing')
        ->group(function () {
            Route::prefix('/price_list')
                ->name('.priceList')
                ->group(function () {
                    Route::get('/', [IndexController::class, 'index'])->name('.index');
                    Route::get('/{store}', [ByStoreShowController::class, 'show'])->name('.byStore');
                });

            Route::prefix('/{store}/products')
                ->name('.products')
                ->group(function () {
                    Route::get('/{product_id}', [ProductShowController::class, 'showByStore'])->name('.showByStore');
                    Route::post('/export', [ByStoreExportController::class, 'export'])->name('.export');


                });

            Route::prefix('/price_log')
                ->name('.priceLog')
                ->group(function () {
                    Route::get('/{store}/last_updated_products', [PriceLogController::class, 'lastUpdatedProducts'])->name('.lastUpdatedProducts');
                });

            Route::prefix('/products')
                ->name('.products')
                ->group(function () {
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
