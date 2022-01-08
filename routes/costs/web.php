<?php

use Illuminate\Support\Facades\Route;
use Src\Costs\Presentation\Http\Controllers\Web\CostsController;
use Src\Costs\Presentation\Http\Controllers\Web\PurchaseInvoicesController;
use Src\Costs\Presentation\Http\Controllers\Web\PurchaseItemsController;
use Src\Costs\Presentation\Http\Controllers\Web\SyncController;
use Src\Costs\Presentation\Http\Controllers\Web\UploadSpreadsheet;

Route::middleware('auth')->group(function () {
    Route::prefix('/costs')
        ->name('costs')
        ->group(function () {
            Route::get('/purchase-invoice/{uuid}', [PurchaseInvoicesController::class, 'showPurchaseInvoices'])
                ->name('.showPurchaseInvoices');

            Route::get('/purchase-invoices', [PurchaseInvoicesController::class, 'listPurchaseInvoices'])
                ->name('.listPurchaseInvoices');

            Route::get('/edit', [CostsController::class, 'edit'])
                ->name('.edit');

            Route::post('/sync', [SyncController::class, 'sync'])
                ->name('.sync');

            Route::put('/price_cost/update/{product_id}', [CostsController::class, 'update'])
                ->name('.update');

            Route::put('/purchase-item/link', [PurchaseItemsController::class, 'linkProduct'])
                ->name('.linkProduct');
    });
});
