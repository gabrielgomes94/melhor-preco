<?php

use Illuminate\Support\Facades\Route;
use Src\Products\Application\Http\Controllers\Api\Products\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/product/{sku}', [ProductController::class, 'get'])->middleware('auth:sanctum');
Route::post('/product/{sku}', [ProductController::class, 'post'])->middleware('auth:sanctum');
