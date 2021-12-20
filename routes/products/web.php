<?php

use Illuminate\Support\Facades\Route;
use Src\Costs\Application\Http\Controllers\Web\CostsController;
use Src\Costs\Application\Http\Controllers\Web\UpdateICMSController;
use Src\Products\Application\Http\Controllers\Web\Images\ProductImageController;
use Src\Products\Application\Http\Controllers\Web\Reports\DimensionsController;
use Src\Products\Application\Http\Controllers\Web\Reports\ProductController;
use Src\Products\Application\Http\Controllers\Web\StockTag\StockTagController;
use Src\Products\Application\Http\Controllers\Web\Synchronization\SynchronizationController;

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
            Route::get('/update_icms', [UpdateICMSController::class, 'updateICMS'])->name('.updateICMS');
            Route::put('/update_icms/spreadsheet', [UpdateICMSController::class, 'doUpdateICMS'])->name('.doUpdateICMS');

            Route::prefix('/stock_tags')
                ->name('.stock_tags')
                ->group(function () {
                    Route::get('/', [StockTagController::class, 'createQrCode'])->name('.index');

                    Route::post('/generate', [StockTagController::class, 'generateQrCode'])->name('.generate');
                });

            Route::prefix('/reports')
                ->name('.reports')
                ->group(function () {
                    Route::get('/show_info/{sku}', [ProductController::class, 'get'])->name('.show');

                    Route::get('/over_dimension', [DimensionsController::class, 'overDimension'])
                        ->name('.overDimension');
                });

            Route::prefix('/costs')
                ->name('.costs')
                ->group(function () {
                    Route::get('/edit', [CostsController::class, 'edit'])->name('.edit');

                    Route::put('/price_cost/update/{product_id}', [CostsController::class, 'update'])->name('.update');
                });
        });
});
