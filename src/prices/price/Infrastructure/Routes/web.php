<?php

use Illuminate\Support\Facades\Route;
use Src\Prices\Price\Application\Http\Controllers\Web\Price\UpdateController;
use Src\Prices\Price\Application\Http\Controllers\Web\PriceList\IndexController;
use Src\Prices\Price\Application\Http\Controllers\Web\PriceList\ShowController;
use Src\Prices\Price\Application\Http\Controllers\Web\PriceLog\PriceLogController;
use Src\Prices\Price\Application\Http\Controllers\Web\Price\ShowController as ProductShowController;

Route::middleware('auth')->group(function () {
    Route::prefix('pricing')
        ->name('pricing')
        ->group(function () {
            Route::prefix('/price_list')
                ->name('.priceList')
                ->group(function () {
                    Route::get('/', [IndexController::class, 'index'])->name('.index');
                    Route::get('/{store}', [ShowController::class, 'show'])->name('.byStore');
                });

            Route::prefix('/{store}/products')
                ->name('.products')
                ->group(function () {
                    Route::get('/{product_id}', [ProductShowController::class, 'showByStore'])
                        ->name('.showByStore');
                });

            Route::prefix('/price_log')
                ->name('.priceLog')
                ->group(function () {
                    Route::get(
                        '/{store}/last_updated_products',
                        [PriceLogController::class, 'lastUpdatedProducts']
                    )->name('.lastUpdatedProducts');
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
        });
});
