<?php

use Illuminate\Support\Facades\Route;
use Src\Products\Infrastructure\Laravel\Http\Controllers\Web\ProductImageController;
use Src\Products\Infrastructure\Laravel\Http\Controllers\Web\ProductController;
use Src\Products\Infrastructure\Laravel\Http\Controllers\Web\ProductInformationsReport;
use Src\Products\Infrastructure\Laravel\Http\Controllers\Web\SynchronizationController;

Route::middleware('auth')->group(function () {
    Route::prefix('product')->group(function () {
        Route::get('upload_images', [ProductImageController::class, 'uploadImage'])
            ->name('product.images.upload_form');

        Route::post('/file-upload', [ProductImageController::class, 'upload'])
            ->name('product.images.upload');
    });

    Route::prefix('products')
        ->name('products')
        ->group(function () {
            Route::put('/sync', [SynchronizationController::class, 'doSync'])
                ->name('.sync');

            Route::prefix('/reports')
                ->name('.reports')
                ->group(function () {
                    Route::get('/show_info/{sku}', [ProductController::class, 'get'])
                        ->name('.show');

                    Route::get('/informations', ProductInformationsReport::class)
                        ->name('.informations');
                });
        });

    Route::prefix('categorias')
        ->name('categories')->group(function () {
            Route::put('/sincronizar', [SynchronizationController::class, 'doSyncCategory'])->name('.sync');
        });
});
