<?php

use App\Http\Controllers\Front\Sales\ListController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('sales')
        ->name('sales')
        ->group(function () {
            Route::get('/list', [ListController::class, 'list'])->name('.list');

            Route::get('/export', [ListController::class, 'export'])->name('.export');
        });
});
