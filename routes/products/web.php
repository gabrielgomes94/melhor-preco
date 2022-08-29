<?php

use Illuminate\Support\Facades\Route;
use Src\Products\Infrastructure\Laravel\Http\Controllers\Web\ProductImageController;
use Src\Products\Infrastructure\Laravel\Http\Controllers\Web\Reports\ProductDetailsController;
use Src\Products\Infrastructure\Laravel\Http\Controllers\Web\Reports\ProductsInformationsController;
use Src\Products\Infrastructure\Laravel\Http\Controllers\Web\SynchronizationController;

Route::middleware('auth')->group(function () {
    Route::prefix('produtos')
        ->name('products')
        ->group(function () {
            Route::put('/sincronizar', [SynchronizationController::class, 'sync'])
                ->name('.sync');

            Route::prefix('/upload-de-imagens')
                ->name('.images')
                ->group(function() {
                    Route::get('/', [ProductImageController::class, 'uploadImage'])
                        ->name('.upload_form');

                    Route::post('/', [ProductImageController::class, 'upload'])
                        ->name('.upload');
                });

            Route::prefix('/relatorios')
                ->name('.reports')
                ->group(function () {
                    Route::get('/detalhes/{sku}', [ProductDetailsController::class, 'get'])
                        ->name('.show');

                    Route::get('/informacoes-gerais', ProductsInformationsController::class)
                        ->name('.informations');
                });
        });

    Route::prefix('categorias')
        ->name('categories')->group(function () {
            Route::put('/sincronizar', [SynchronizationController::class, 'syncCategory'])->name('.sync');
        });
});
