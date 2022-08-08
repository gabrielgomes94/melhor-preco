<?php

use Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price\ListController;
use Illuminate\Support\Facades\Route;

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
include 'sales/web.php';
include 'users/web.php';

Route::middleware('auth')->group(function () {
    Route::get('/', ListController::class)->name('home');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');
