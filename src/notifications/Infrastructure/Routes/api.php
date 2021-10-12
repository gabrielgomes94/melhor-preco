<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Route;
use Src\Notifications\Application\Http\Controllers\Api\NotificationsController;

Route::get('/notifications/count', [NotificationsController::class, 'count'])
    ->middleware('auth:sanctum');
