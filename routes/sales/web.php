<?php

use Illuminate\Support\Facades\Route;
use Src\Sales\Infrastructure\Laravel\Http\Controllers\Web\ListController;
use Src\Sales\Infrastructure\Laravel\Http\Controllers\Web\ReportsController;
use Src\Sales\Infrastructure\Laravel\Http\Controllers\Web\SyncController;

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
                    Route::get('/produtos-mais-vendidos', [ReportsController::class, 'mostSelledProducts'])
                        ->name('.mostSelledProducts');
                });
        });
});
