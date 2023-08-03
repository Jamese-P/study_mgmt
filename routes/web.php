<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\TodayController;
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

Route::get('/', [BookController::class, 'index']);

Route::controller(TodayController::class)->group(function () {
    Route::get('/today', 'show');
    Route::post('/today/{book}/complete', 'complete2');
    Route::post('/today/{book}/pass', 'pass');
    Route::get('/today/{book}/{unit}/complete', 'complete');
    Route::post('/today/{book}/{unit}', 'make_log');
});

Route::controller(BookController::class)->group(function () {
    Route::get('/books', 'index');
    Route::post('/books', 'store');
    Route::get('/books/create', 'create');
    Route::get('/books/{book}', 'show');
    Route::put('/books/{book}', 'update');
    Route::get('/books/{book}/edit', 'edit');
});
