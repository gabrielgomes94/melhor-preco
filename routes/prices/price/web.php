<?php

use Illuminate\Support\Facades\Route;
use Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\Price\CalculateController;
use Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\Price\SyncController;
use Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\Price\UpdateController;
use Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\Price\IndexController;
use Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\Price\ListController;
use Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\PriceLog\PriceLogController;

Route::middleware('auth')->group(function () {
    Route::prefix('pricing')
        ->name('pricing')
        ->group(function () {
            Route::prefix('/price_list')
                ->name('.priceList')
                ->group(function () {
                    Route::get('/', [IndexController::class, 'index'])->name('.index');
                    Route::get('/{store}', [ListController::class, 'show'])->name('.byStore');
                });

            Route::prefix('/{store_slug}/products')
                ->name('.products')
                ->group(function () {
                    Route::get('/{product_id}', CalculateController::class)
                        ->name('.calculate');
                });

            Route::post('/{store_slug}/sync', [SyncController::class, 'sync'])
                ->name('.sync');

            Route::post('/sync', [SyncController::class, 'syncAll'])
                ->name('.syncAll');

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
