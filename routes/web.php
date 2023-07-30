<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TodayController;

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

Route::get('/', [BookController::class,'index']);
Route::get('/today', [TodayController::class,'show']);

Route::post('/today/{book}/complete', [TodayController::class,'complete']);
Route::post('/today/{book}/pass', [TodayController::class,'pass']);
