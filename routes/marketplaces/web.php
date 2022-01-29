<?php

use Illuminate\Support\Facades\Route;
use Src\Marketplaces\Presentation\Http\Controllers\CommissionController;
use Src\Marketplaces\Presentation\Http\Controllers\MarketplacesController;

Route::middleware('auth')->group(function () {
    Route::prefix('marketplaces')
        ->name('marketplaces')
        ->group(function() {
            Route::get('/criar', [MarketplacesController::class, 'create'])->name('.create');
            Route::post('/criar', [MarketplacesController::class, 'store'])->name('.store');
            Route::get('/', [MarketplacesController::class, 'list'])->name('.list');


            Route::post('/{marketplace_slug}/definir-comissoes', [CommissionController::class, 'doSetCommission'])
                ->name('.doSetCommission');

            Route::get('/{marketplace_slug}/comissao/', [CommissionController::class, 'setCommission'])
                ->name('.setCommission');
        });
});
