<?php

use App\Http\Controllers\Front\Notifications\NotificationsController;
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

include 'web/pricing.php';
include 'web/product.php';
include 'web/sales.php';

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('pages.dashboard');
    })->name('home');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::name('notifications')->group(function () {
        Route::get('/inbox', [NotificationsController::class, 'list'])->name('.list');
        Route::get('/inbox/{id}', [NotificationsController::class, 'show'])->name('.show');
    });
});
