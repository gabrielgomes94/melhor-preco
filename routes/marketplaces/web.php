<?php

use Illuminate\Support\Facades\Route;
use Src\Marketplaces\Presentation\Http\Controllers\CommissionController;
use Src\Marketplaces\Presentation\Http\Controllers\StoresController;

Route::middleware('auth')->group(function () {
    Route::prefix('marketplaces')
        ->name('marketplaces')
        ->group(function() {
            Route::get('/create', [StoresController::class, 'create'])->name('.create');
            Route::post('/create', [StoresController::class, 'store'])->name('.store');
            Route::get('/', [StoresController::class, 'list'])->name('.list');

            Route::get('/set-commission', [CommissionController::class, 'setCommission'])->name('.setCommission');
            Route::post('/set-commission', [CommissionController::class, 'doSetCommission'])->name('.doSetCommission');
        });
});
