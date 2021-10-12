<?php

use Src\Notifications\Application\Http\Controllers\Web\NotificationsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::name('notifications')->group(function () {
        Route::get('/inbox', [NotificationsController::class, 'list'])->name('.list');

        Route::put('/inbox/{id}/readed_status', [NotificationsController::class, 'updateReadedStatus'])
            ->name('.updateReadedStatus');

        Route::put('/inbox/{id}/solved_status', [NotificationsController::class, 'updateSolvedStatus'])
            ->name('.updateSolvedStatus');
    });
});
