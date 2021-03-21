<?php

use App\Http\Controllers\Front\Prices\PricesCalculatorController;
use App\Http\Controllers\Front\Prices\PricesController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\Pricing\ShowPricingController;
use App\Http\Controllers\Front\Products\ProductImageController;
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

Route::middleware('auth')->group(function() {
    Route::get('/', function () {
        return view('dashboard');
    })->name('home');

    Route::prefix('product')->group(function() {
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

    Route::prefix('pricing')->name('pricing')->group(function() {
        Route::prefix('campaigns')->name('.campaigns')->group(function() {
            Route::get('/', [ShowPricingController::class, 'list'])->name('.list');
            Route::get('/show/{id}', [ShowPricingController::class, 'show'])->name('.show');

            Route::get('/create', [CreatePricingController::class, 'create'])->name('.create');
            Route::post('/store', [CreatePricingController::class, 'store'])->name('.store');
        });
    });
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');
