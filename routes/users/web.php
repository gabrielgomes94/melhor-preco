<?php

use Illuminate\Support\Facades\Route;
use Src\Users\Infrastructure\Laravel\Http\Controllers\IntegrationsController;

Route::middleware('auth')
    ->name('users')
    ->group(function () {
        Route::prefix('configuracoes')
            ->name('.settings')
            ->group(function () {
                Route::get('/integracoes', [IntegrationsController::class, 'list'])
                    ->name('.integrations');

                Route::post('/integracoes', [IntegrationsController::class, 'updateErp'])
                    ->name('.updateErp');
            });
    });
