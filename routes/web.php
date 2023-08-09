<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [TodayController::class, 'show']);

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
