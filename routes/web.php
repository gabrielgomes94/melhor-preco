<?php

use App\Http\Controllers\Front\Pricing\Price\UpdateController;
use App\Http\Controllers\Front\Pricing\PriceList\CreateController;
use App\Http\Controllers\Front\Pricing\PriceList\ExportController;
use App\Http\Controllers\Front\Pricing\PriceList\ListController;
use App\Http\Controllers\Front\Pricing\PriceList\ShowController;
use App\Http\Controllers\Front\Pricing\Product\RemoveController;
use App\Http\Controllers\Front\Pricing\Product\ShowController as ProductShowController;
use App\Http\Controllers\Front\Pricing\Product\UpdateController as UpdateProductController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\Products\ProductImageController;
use App\Http\Controllers\Front\Products\ReportsController;
use App\Http\Controllers\Front\Products\SyncronizationController as ProductSyncronizationController;
use App\Http\Controllers\Front\Products\UploadController as ProductsUploadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('pages.dashboard');
    })->name('home');

    Route::prefix('product')->group(function () {
        Route::get('upload_images', [ProductImageController::class, 'uploadImage'])
            ->name('product.images.upload_form');

        Route::post('/file-upload', [ProductImageController::class, 'upload'])
            ->name('product.images.upload');
    });

    Route::get('/product/{sku}/stock', [ProductController::class, 'get'])->name('product.show');
    Route::get('/product/qr_codes', [ProductController::class, 'createQrCode'])->name('product.qr_codes');
    Route::post('/product/qr_codes/new', [ProductController::class, 'generateQrCode']);

    Route::prefix('pricing')
        ->name('pricing')
        ->group(function () {
            Route::get('/', [ListController::class, 'list'])->name('.list');
            Route::get('/create', [CreateController::class, 'create'])->name('.create');
            Route::get('/{id}', [ShowController::class, 'show'])->name('.show');

            Route::post('{id}/export', [ExportController::class, 'export'])->name('.export');

            Route::prefix('/price_list')
                ->name('.priceList')
                ->group(function () {
                    Route::get('/all', [ListController::class, 'all'])->name('.all');
                    Route::get('/custom', [ListController::class, 'list'])->name('.custom');
                    Route::get('/custom/create', [CreateController::class, 'create'])->name('.create');

                    Route::get('/{store}', [ShowController::class, 'byStore'])->name('.byStore');
                });

            Route::prefix('/{store}/products')
                ->name('.products')
                ->group(function () {
                    Route::get('/{product_id}', [ProductShowController::class, 'showByStore'])
                        ->name('.showByStore');

                    Route::post('/export', [ExportController::class, 'exportStore'])->name('.exportStore');
                });


            Route::prefix('/products')
            ->name('.products')
            ->group(function () {
                Route::get('/{product_id}', [ProductShowController::class, 'show'])
                    ->name('.show');

                Route::put('/{product_id}', [UpdateProductController::class, 'update'])
                    ->name('.update');

                Route::delete('/{product_id}', [RemoveController::class, 'remove'])
                    ->name('.remove');


                Route::prefix('/{product_id}/price')
                    ->name('.prices')
                    ->group(function () {
                        Route::put('/{price_id}', [UpdateController::class, 'update'])
                            ->name('.update');
                    });
            });

            Route::prefix('campaigns')->name('.campaigns')->group(function () {
                Route::post('/store', [CreateController::class, 'store'])->name('.store');
            });
        });

    Route::prefix('products')
        ->name('products')
        ->group(function () {
            Route::get('/sync', [ProductSyncronizationController::class, 'sync'])->name('.sync');
            Route::put('/sync', [ProductSyncronizationController::class, 'doSync'])->name('.doSync');
            Route::get('/update_icms', [ProductsUploadController::class, 'updateICMS'])->name('.updateICMS');
            Route::put('/update_icms/spreadsheet', [ProductsUploadController::class, 'doUpdateICMS'])->name('.doUpdateICMS');

            Route::get('/reports/over-dimension', [ReportsController::class, 'overDimension'])->name('.reports.overDimension');
        });
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');
