<?php

declare(strict_types=1);

use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodayController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('/', [TodayController::class, 'show'])->name('today')->middleware(['auth']);
Route::get('/', function () {
    return view('welcome');
});

Route::controller(TodayController::class)->middleware(['auth'])->group(function () {
    Route::get('/today', 'show')->name('today');
    Route::put('/today/{book}/{unit}/pass', 'pass')->name('today.pass');
    Route::get('/today/{book}/{unit}/complete', 'complete')->name('today.complete');
    Route::put('/today/{book}/{unit}', 'make_log')->name('today.make_log');
});

Route::controller(BookController::class)->middleware(['auth'])->group(function () {
    Route::get('/books', 'index')->name('book.index');
    Route::post('/books', 'store')->name('book.store');
    Route::get('/books/create', 'create')->name('book.create');
    Route::get('/books/{book}', 'show')->name('book.show');
    Route::put('/books/{book}', 'update')->name('book.update');
    Route::get('/books/{book}/edit', 'edit')->name('book.edit');
    Route::get('/books/{book}/relearn', 'relearn')->name('book.relearn');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
