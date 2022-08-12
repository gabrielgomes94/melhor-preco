<?php

use Illuminate\Support\Facades\Route;
use Src\Users\Infrastructure\Laravel\Http\Controllers\IntegrationsController;
use Src\Users\Infrastructure\Laravel\Http\Controllers\ProfileController;
use Src\Users\Infrastructure\Laravel\Http\Controllers\TaxesController;

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

                Route::get('/impostos', [TaxesController::class, 'get'])
                    ->name('.taxes');

                Route::post('/impostos', [TaxesController::class, 'update'])
                    ->name('.taxes');

                Route::get('/perfil', [ProfileController::class, 'show'])
                    ->name('.profile');

                Route::post('/perfil', [ProfileController::class, 'updateProfile'])
                    ->name('.profile');

                Route::post('atualizar-senha', [ProfileController::class, 'updatePasword'])
                    ->name('.updatePassword');
            });
    });
