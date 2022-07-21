<?php

use Illuminate\Support\Facades\Route;
use Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Promotions\CalculatePromotionController;
use Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Promotions\EditPromotionController;
use Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Promotions\ExportSpreadsheetController;
use Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Promotions\ListPromotionsController;
use Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Promotions\PromotionsController;
use Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Promotions\ShowPromotionController;

Route::middleware('auth')->group(function () {
    Route::prefix('promocoes')
        ->name('promotions')
        ->group(function() {
//            Route::get('/', ListPromotionsController::class)
//                ->name('.index');
//
//            Route::get('/promocao/{promotionUuid}', ShowPromotionController::class)
//                ->name('.show');
//
//            Route::get('/calcular', [PromotionsController::class, 'calculate'])
//                ->name('.calculate');
//
//            Route::post('/calcular', CalculatePromotionController::class)
//                ->name('.doCalculate');
//
//            Route::get('/exportar/{promotionUuid}', ExportSpreadsheetController::class)
//                ->name('.export');
//
//            Route::get('/editar/{promotionUuid}', [EditPromotionController::class, 'edit'])
//                ->name('.edit');
//
//            Route::patch('/editar/{promotionUuid}', [EditPromotionController::class, 'update'])
//                ->name('.update');
        });
});
