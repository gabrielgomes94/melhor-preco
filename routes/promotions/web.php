<?php

use Illuminate\Support\Facades\Route;
use Src\Promotions\Infrastructure\Laravel\Http\Controllers\CalculatePromotionController;
use Src\Promotions\Infrastructure\Laravel\Http\Controllers\ExportSpreadsheetController;
use Src\Promotions\Infrastructure\Laravel\Http\Controllers\ListPromotionsController;
use Src\Promotions\Infrastructure\Laravel\Http\Controllers\PromotionsController;
use Src\Promotions\Infrastructure\Laravel\Http\Controllers\ShowPromotionController;

Route::middleware('auth')->group(function () {
    Route::prefix('promocoes')
        ->name('promotions')
        ->group(function() {
            Route::get('/', ListPromotionsController::class)
                ->name('.index');

            Route::get('/{promotionUuid}', ShowPromotionController::class)
                ->name('.show');

            Route::get('/magalu', ListPromotionsController::class)
                ->name('.magaluPromotions');

            Route::get('/calcular', [PromotionsController::class, 'calculate'])
                ->name('.calculate');

            Route::post('/calcular', CalculatePromotionController::class)
                ->name('.doCalculate');

            Route::get('/exportar/{promotionUuid}', ExportSpreadsheetController::class)
                ->name('.export');
        });
});