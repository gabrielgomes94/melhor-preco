<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Products\Costs\CostsController;
use App\Http\Controllers\Front\Products\Images\ProductImageController;
use App\Http\Controllers\Front\Products\Reports\DimensionsController;
use App\Http\Controllers\Front\Products\Reports\ProductController;
use App\Http\Controllers\Front\Products\StockTag\StockTagController;
use App\Http\Controllers\Front\Products\SyncronizationController as ProductSyncronizationController;
use App\Http\Controllers\Front\Products\Costs\UpdateICMSController as ProductsUploadController;

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
            Route::get('/sync', [ProductSyncronizationController::class, 'sync'])->name('.sync');
            Route::put('/sync', [ProductSyncronizationController::class, 'doSync'])->name('.doSync');
            Route::get('/update_icms', [ProductsUploadController::class, 'updateICMS'])->name('.updateICMS');
            Route::put('/update_icms/spreadsheet', [ProductsUploadController::class, 'doUpdateICMS'])->name('.doUpdateICMS');

            Route::prefix('/stock_tags')
                ->name('.stock_tags')
                ->group(function () {
                    Route::get('/', [StockTagController::class, 'createQrCode'])->name('.index');
                    Route::post('/generate', [StockTagController::class, 'generateQrCode'])->name('.generate');
                });

            Route::prefix('/reports')
                ->name('.reports')
                ->group(function () {
                    Route::get('/show-info/{sku}', [ProductController::class, 'get'])->name('.show');

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
