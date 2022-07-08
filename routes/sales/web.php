<?php

use Illuminate\Support\Facades\Route;
use Src\Sales\Infrastructure\Laravel\Http\Controllers\Web\ListController;
use Src\Sales\Infrastructure\Laravel\Http\Controllers\Web\ReportsController;
use Src\Sales\Infrastructure\Laravel\Http\Controllers\Web\SyncController;

Route::middleware('auth')->group(function () {
    Route::prefix('sales')
        ->name('sales')
        ->group(function () {
            Route::get('/list', [ListController::class, 'list'])->name('.list');
            Route::get('/show', [ListController::class, 'show'])->name('.show');
            Route::post('/sync', [SyncController::class, 'sync'])->name('.sync');

            Route::prefix('/reports')
                ->name('.reports')
                ->group(function () {
                    Route::get('/most-selled-products', [ReportsController::class, 'mostSelledProducts'])
                        ->name('.mostSelledProducts');
                });
        });
});
