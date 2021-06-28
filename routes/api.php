<?php

use App\Http\Controllers\API\Pricing\CalculatePricesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/product/{sku}', [ProductController::class, 'get'])->middleware('auth:sanctum');
Route::post('/product/{sku}', [ProductController::class, 'post'])->middleware('auth:sanctum');



Route::prefix('pricing')->name('pricing')->group(function () {
    Route::prefix('/products/{product_id}/prices/')
        ->name('.products.prices')
        ->group(function () {
            Route::post('/{price_id}/calculate', [CalculatePricesController::class, 'calculate'])
                ->name('.calculate');
        });
});
