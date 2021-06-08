<?php

use App\Http\Controllers\Front\Prices\PricesCalculatorController;
use App\Http\Controllers\Front\Prices\PricesController;
use App\Http\Controllers\Front\Pricing\ExportSpreadsheetController;
use App\Http\Controllers\Front\Pricing\ListPricingController;
use App\Http\Controllers\Front\Pricing\Product\UpdateController;
use App\Http\Controllers\Front\Pricing\RemoveProductController;
use App\Http\Controllers\Front\Pricing\ShowProductPricingController;
use App\Http\Controllers\Front\Pricing\UpdatePriceController;
use App\Http\Controllers\Front\Pricing\Product\UpdateController as UpdateProductController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\Pricing\ShowPricingController;
use App\Http\Controllers\Front\Products\ProductImageController;
use App\Http\Controllers\Front\Products\ReportsController;
use App\Http\Controllers\Front\Products\SyncronizationController as ProductSyncronizationController;
use App\Http\Controllers\Front\Products\UploadController as ProductsUploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Pricing\CreatePricingController;

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
        return view('dashboard');
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

    Route::prefix('prices')->name('prices')->group(function () {
        Route::get('single', [PricesController::class, 'single'])->name('.single');

        Route::post('calculate_single', [PricesCalculatorController::class, 'calculate_single'])->name('.calculate_single');
    });

    Route::prefix('pricing')->name('pricing')->group(function () {
        Route::get('/', [ListPricingController::class, 'list'])->name('.list');
        Route::get('/create', [CreatePricingController::class, 'create'])->name('.create');
        Route::get('/{id}', [ShowPricingController::class, 'show'])->name('.show');

        Route::post('{id}/export', [ExportSpreadsheetController::class, 'export'])->name('.export');

        Route::prefix('/{pricing_id}/products')
            ->name('.products')
            ->group(function () {
                Route::get('/{product_id}', [ShowProductPricingController::class, 'show'])
                    ->name('.show');

                Route::put('/{product_id}', [UpdateProductController::class, 'update'])
                    ->name('.update');

                Route::delete('/{product_id}', [RemoveProductController::class, 'remove'])
                    ->name('.remove');


                Route::prefix('/{product_id}/price')
                    ->name('.prices')
                    ->group(function () {
                        Route::put('/{price_id}', [UpdatePriceController::class, 'update'])
                            ->name('.update');
                    });
            });

        Route::prefix('campaigns')->name('.campaigns')->group(function () {
            Route::post('/store', [CreatePricingController::class, 'store'])->name('.store');
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
