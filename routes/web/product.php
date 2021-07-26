<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\Products\CostsController;
use App\Http\Controllers\Front\Products\ProductImageController;
use App\Http\Controllers\Front\Products\ReportsController;
use App\Http\Controllers\Front\Products\SyncronizationController as ProductSyncronizationController;
use App\Http\Controllers\Front\Products\UploadController as ProductsUploadController;

Route::middleware('auth')->group(function () {

    Route::prefix('product')->group(function () {
        Route::get('upload_images', [ProductImageController::class, 'uploadImage'])
            ->name('product.images.upload_form');

        Route::post('/file-upload', [ProductImageController::class, 'upload'])
            ->name('product.images.upload');
    });

    Route::get('/product/{sku}/stock', [ProductController::class, 'get'])->name('product.show');
    Route::get('/product/qr_codes', [ProductController::class, 'createQrCode'])->name('product.qr_codes');
    Route::post('/product/qr_codes/new', [ProductController::class, 'generateQrCode']);

    Route::prefix('products')
        ->name('products')
        ->group(function () {
            Route::get('/sync', [ProductSyncronizationController::class, 'sync'])->name('.sync');
            Route::put('/sync', [ProductSyncronizationController::class, 'doSync'])->name('.doSync');
            Route::get('/update_icms', [ProductsUploadController::class, 'updateICMS'])->name('.updateICMS');
            Route::put('/update_icms/spreadsheet', [ProductsUploadController::class, 'doUpdateICMS'])->name('.doUpdateICMS');
            Route::get('/reports/over-dimension', [ReportsController::class, 'overDimension'])->name('.reports.overDimension');

            Route::prefix('/costs')
                ->name('.costs')
                ->group(function () {
                    Route::get('/edit', [CostsController::class, 'edit'])->name('.edit');

                    Route::put('/price_cost/update/{product_id}', [CostsController::class, 'update'])->name('.update');
                });
        });
});
