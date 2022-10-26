<?php

use Illuminate\Support\Facades\Route;
use Src\Sales\Application\Http\Controllers\Web\ListController;
use Src\Sales\Application\Http\Controllers\Web\SyncController;

Route::middleware('auth')->group(function () {
    Route::prefix('vendas')
        ->name('sales')
        ->group(function () {
            Route::get('/lista', [ListController::class, 'list'])->name('.list');
            Route::get('/detalhes/{saleId}', [ListController::class, 'show'])->name('.show');
            Route::post('/sincronizar', [SyncController::class, 'sync'])->name('.sync');

            Route::prefix('/relatorios')
                ->name('.reports')
                ->group(function () {
                    // Define reports routes here
                });
        });
});
