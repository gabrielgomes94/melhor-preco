<?php

use Illuminate\Support\Facades\Route;
use Src\Calculator\Presentation\Http\Controllers\API\CalculatePricesController;

Route::prefix('pricing')->name('pricing')->group(function () {
    Route::prefix('/products/{product_id}/prices/')
        ->name('.products.prices')
        ->group(function () {
            Route::get('/{price_id}', [\Src\Prices\Presentation\Http\Controllers\Web\Price\CalculateController::class, 'showByStore'])
                ->name('.calculate');
        });
});
