<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageUploaderController;

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

Route::get('/', function () {
    return view('upload-images');
})->middleware('auth');

Route::get('/sucesso', function () {
    return view('feedback');
});

// [UserController::class, 'index']
Route::post('/file-upload', [ImageUploaderController::class, 'upload'])->middleware('auth');




Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
