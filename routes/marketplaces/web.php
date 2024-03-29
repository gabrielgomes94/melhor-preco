<?php

use Illuminate\Support\Facades\Route;
use Src\Marketplaces\Infrastructure\Laravel\Http\Controllers\CommissionController;
use Src\Marketplaces\Infrastructure\Laravel\Http\Controllers\FreightController;
use Src\Marketplaces\Infrastructure\Laravel\Http\Controllers\MarketplacesController;

Route::middleware('auth')->group(function () {
    Route::prefix('marketplaces')
        ->name('marketplaces')
        ->group(function () {
            Route::get('/', [MarketplacesController::class, 'list'])
                ->name('.list');

            Route::get('/criar', [MarketplacesController::class, 'create'])
                ->name('.create');

            Route::post('/criar', [MarketplacesController::class, 'store'])
                ->name('.store');

            Route::get('/{marketplace_slug}/editar', [MarketplacesController::class, 'edit'])
                ->name('.edit');

            Route::post('/{marketplace_slug}/editar', [MarketplacesController::class, 'update'])
                ->name('.update');

            Route::post(
                '/{marketplace_slug}/definir-comissoes-por-categoria',
                [CommissionController::class, 'doSetCommissionByCategory']
            )->name('.doSetCommissionByCategory');

            Route::post(
                '/{marketplace_slug}/definir-comissao-unica',
                [CommissionController::class, 'doSetUniqueCommission']
            )->name('.doSetUniqueCommission');

            Route::get('/{marketplace_slug}/comissao', [CommissionController::class, 'editCommission'])
                ->name('.setCommission');

            Route::get('/{marketplace_slug}/frete', [FreightController::class, 'edit'])
                ->name('.setFreight');

            Route::post('/{marketplace_slug}/frete', [FreightController::class, 'update'])
                ->name('.doSetFreight');

            Route::prefix('/downloads')
                ->name('.downloads')
                ->group(function () {
                    Route::get('/template-tabela-frete', [FreightController::class, 'downloadTemplate'])
                        ->name('.template');

                    Route::get(
                        '/{marketplace_slug}/tabela-frete',
                        [FreightController::class, 'downloadFreightTable']
                    )->name('.freightTable');
                });
        });
});
