<?php

use Src\Users\Infrastructure\Laravel\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Src\Users\Infrastructure\Laravel\Http\Controllers\SynchronizationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

include 'costs/web.php';
include 'notifications/web.php';
include 'marketplaces/web.php';
include 'products/web.php';
include 'prices/price/web.php';
include 'promotions/web.php';
include 'sales/web.php';
include 'users/web.php';

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::post('/sync', [SynchronizationController::class, 'sync'])->name('dashboard.sync');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');
