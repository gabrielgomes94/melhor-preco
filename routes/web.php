<?php

use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\Products\ProductImageController;
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

    Route::get('/product/{sku}/stock', [ProductController::class, 'getWithStock'])->name('product.show');
    Route::get('/product/qr_codes', [ProductController::class, 'createQrCode'])->name('product.qr_codes');
    Route::post('/product/qr_codes/new', [ProductController::class, 'generateQrCode']);
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');
