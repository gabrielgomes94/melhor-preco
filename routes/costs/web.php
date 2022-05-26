<?php

use Illuminate\Support\Facades\Route;
use Src\Costs\Infrastructure\Laravel\Http\Controllers\Web\CostsController;
use Src\Costs\Infrastructure\Laravel\Http\Controllers\Web\CostsDetailedController;
use Src\Costs\Infrastructure\Laravel\Http\Controllers\Web\ListCostsController;
use Src\Costs\Infrastructure\Laravel\Http\Controllers\Web\PurchaseInvoicesController;
use Src\Costs\Infrastructure\Laravel\Http\Controllers\Web\PurchaseItemsController;
use Src\Costs\Infrastructure\Laravel\Http\Controllers\Web\SyncController;
use Src\Costs\Infrastructure\Laravel\Http\Controllers\Web\UploadSpreadsheet;

Route::middleware('auth')->group(function () {
    Route::prefix('/custos')
        ->name('costs')
        ->group(function () {
            Route::prefix('/produtos')
                ->name('.product')
                ->group(function() {
                    Route::get('/lista', ListCostsController::class)
                        ->name('.list');

                    Route::get('/detalhes/{sku}', CostsDetailedController::class)
                        ->name('.show');

                    Route::put('/atualizar/{product_id}', [CostsController::class, 'update'])
                        ->name('.update');
            });

            Route::prefix('/notas-fiscais')
                ->group(function() {
                    Route::get('/detalhes/{uuid}', [PurchaseInvoicesController::class, 'showPurchaseInvoices'])
                        ->name('.showPurchaseInvoices');

                    Route::get('/lista', [PurchaseInvoicesController::class, 'listPurchaseInvoices'])
                        ->name('.listPurchaseInvoices');

                    Route::put('/vincular-item', [PurchaseItemsController::class, 'linkProduct'])
                        ->name('.linkProduct');
                });

            Route::post('/sincronizar', [SyncController::class, 'sync'])
                ->name('.sync');
        });
});
