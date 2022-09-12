<?php

use Illuminate\Support\Facades\Route;
use Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price\CalculateController;
use Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price\MassCalculateController;
use Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price\SyncController;
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

            Route::prefix('/{store_slug}/calcularEmMassa')
                ->name('.massCalculate')
                ->group(function() {
                    Route::get('/', MassCalculateController::class)->name('.calculate');
                });

            Route::prefix('/{store_slug}/produtos')
                ->name('.products')
                ->group(function () {
                    Route::get('/{product_id}', CalculateController::class)
                        ->name('.calculate');
                });

            Route::post('/{marketplace_slug}/sincronizar', [SyncController::class, 'sync'])
                ->name('.sync');

            Route::post('/sincronizar', [SyncController::class, 'syncAll'])
                ->name('.syncAll');
        });
});
