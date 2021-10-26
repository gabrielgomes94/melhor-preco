<?php

use Illuminate\Support\Facades\Route;
use Src\Prices\Calculator\Application\Http\Controllers\API\CalculatePricesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('pricing')->name('pricing')->group(function () {
    Route::prefix('/products/{product_id}/prices/')
        ->name('.products.prices')
        ->group(function () {
            Route::post('/{price_id}/calculate', [CalculatePricesController::class, 'calculate'])
                ->name('.calculate');
        });
});
