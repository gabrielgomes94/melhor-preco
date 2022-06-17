<?php

use Illuminate\Support\Facades\Route;
use Src\Products\Presentation\Http\Controllers\Web\Images\ProductImageController;
use Src\Products\Presentation\Http\Controllers\Web\Reports\DimensionsController;
use Src\Products\Presentation\Http\Controllers\Web\Reports\ProductController;
use Src\Products\Presentation\Http\Controllers\Web\Reports\ProductInformations;
use Src\Products\Presentation\Http\Controllers\Web\Synchronization\SynchronizationController;

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
            Route::get('/sync', [SynchronizationController::class, 'sync'])->name('.sync');
            Route::put('/sync', [SynchronizationController::class, 'doSync'])->name('.doSync');

            Route::prefix('/reports')
                ->name('.reports')
                ->group(function () {
                    Route::get('/show_info/{sku}', [ProductController::class, 'get'])->name('.show');

                    Route::get('/informations', ProductInformations::class)->name('.informations');

                    Route::get('/over_dimension', [DimensionsController::class, 'overDimension'])
                        ->name('.overDimension');
                });
        });
});
