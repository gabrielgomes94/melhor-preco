<?php

use Illuminate\Support\Facades\Route;
use Src\Marketplaces\Presentation\Http\Controllers\CommissionController;
use Src\Marketplaces\Presentation\Http\Controllers\StoresController;

Route::middleware('auth')->group(function () {
    Route::prefix('marketplaces')
        ->name('marketplaces')
        ->group(function() {
            Route::get('/criar', [StoresController::class, 'create'])->name('.create');
            Route::post('/criar', [StoresController::class, 'store'])->name('.store');
            Route::get('/', [StoresController::class, 'list'])->name('.list');

            Route::get('/definir-comissoes', [CommissionController::class, 'setCommission'])->name('.setCommission');
            Route::post('/definir-comissoes', [CommissionController::class, 'doSetCommission'])->name('.doSetCommission');
        });
});
