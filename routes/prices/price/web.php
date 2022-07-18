<?php

use Illuminate\Support\Facades\Route;
use Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price\CalculateController;
use Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price\SyncController;
use Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price\UpdateController;
use Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price\ListController;

Route::middleware('auth')->group(function () {
    Route::prefix('calculadora')
        ->name('pricing')
        ->group(function () {
            Route::prefix('/precos')
                ->name('.priceList')
                ->group(function () {
                    Route::get('/{marketplaceSlug?}', ListController::class)->name('.byStore');
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
