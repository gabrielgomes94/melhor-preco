<?php

use Illuminate\Support\Facades\Route;
use Src\Promotions\Presentation\Http\Controllers\CalculatePromotionController;
use Src\Promotions\Presentation\Http\Controllers\PromotionsController;

Route::middleware('auth')->group(function () {
    Route::prefix('promocoes')
        ->name('promotions')
        ->group(function() {
            Route::get('/', [PromotionsController::class, 'index'])
                ->name('.index');

            Route::get('/calcular', [PromotionsController::class, 'calculate'])
                ->name('.calculate');

            Route::post('/calcular', CalculatePromotionController::class)
                ->name('.doCalculate');
        });
});
