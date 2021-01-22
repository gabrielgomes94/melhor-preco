<?php

use App\Http\Controllers\Front\ImageUploaderController;
use App\Http\Controllers\Front\ProductController;
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
    Route::post('/file-upload', [ImageUploaderController::class, 'upload']);

    Route::get('/', function () {
        return view('upload-images');
    })->name('home');

    Route::get('/product/upload_images', function () {
            return view('upload-images');
        })->name('product.upload_images');

    Route::get('/sucesso', function () {
        return view('feedback');
    })->name('sucesso');

    Route::get('/product/{sku}/stock', [ProductController::class, 'getWithStock'])->name('product.show');

    Route::get('/product/qr_codes', [ProductController::class, 'createQrCode'])->name('product.qr_codes');

    Route::post('/product/qr_codes/new', [ProductController::class, 'generateQrCode']);
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');
