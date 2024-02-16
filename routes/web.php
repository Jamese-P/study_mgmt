<?php

declare(strict_types=1);

use App\Http\Controllers\BookController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TodayController;
use Illuminate\Support\Facades\Route;

Route::controller(TodayController::class)->middleware(['auth'])->group(function () {
    Route::get('/today', 'show')->name('today');
    Route::put('/today/complete', 'complete')->name('today.comp');
    Route::put('/today/comp_exp', 'comp_exp')->name('today.comp_exp');
    Route::get('/today/comp_indiv', 'complete_indiv')->name('today.comp_indiv');
    Route::post('/today/comp_indiv', 'complete_indiv_log')->name('today.comp_indiv_log');
    Route::post('/today/{book}/exp', 'update_exp')->name('today.update_exp');
    Route::put('/today/{book}/no_exp', 'update_no_exp')->name('today.update_no_exp');
    Route::put('/today/{book}/{unit}/pass', 'pass')->name('today.pass');
    Route::put('/today/{book}/{unit}/pass_exp', 'pass_exp')->name('today.pass_exp');
});

Route::controller(BookController::class)->middleware(['auth'])->group(function () {
    Route::get('/books', 'index')->name('book.index');
    Route::post('/books', 'store')->name('book.store');
    Route::get('/books/create', 'create')->name('book.create');
    Route::get('/books/{book}', 'show')->name('book.show');
    Route::put('/books/{book}', 'update')->name('book.update');
    Route::delete('/books/{book}', 'destroy')->name('book.destroy');
    Route::get('/books/{book}/edit', 'edit')->name('book.edit');
    Route::get('/books/{book}/relearn', 'relearn')->name('book.relearn');
    Route::put('/books/{book}/relearn', 'make_log_relearn')->name('book.make_log_relearn');
});

Route::controller(LogController::class)->middleware(['auth'])->group(function () {
    Route::get('/logs', 'index')->name('log.index');
    Route::get('/logs/refine', 'refine')->name('log.index.refine');
});

Route::controller(ScheduleController::class)->middleware(['auth'])->group(function () {
    Route::get('/calendar', function () {
        return view('calendar.calendar');
    })->name('calendar');
    Route::post('/calendar/store', 'store')->name('calendar.store');
    Route::post('/calendar/create', 'create')->name('calendar.create');
    Route::post('/calendar/get', 'get')->name('calendar.get');
    Route::put('/calendar', 'update')->name('calendar.update');
    Route::put('/calendar/drop', 'drop')->name('calendar.drop');
    Route::delete('/calendar', 'delete')->name('calendar.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(FileController::class)->prefix('print')->group(function () {
    Route::get('', 'index')->name('print.index');
    Route::get('/a', 'show_base')->name('print.main');
    Route::get('/high', 'show_high')->name('print.high');
    Route::get('/sinken', 'sinken')->name('print.sinken');
    Route::get('/eiken', 'eiken')->name('print.eiken');
    Route::get('/tmp', 'tmp')->name('print.tmp');
});

require __DIR__.'/auth.php';
