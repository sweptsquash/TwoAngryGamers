<?php

use App\Http\Controllers\EditorController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['api', 'guest', 'throttle:20,1'])->group(function () {
    Route::prefix('schedule')->name('schedule.')->group(function () {
        Route::get('/', [ScheduleController::class, 'scheduleList'])->name('list');
        Route::get('/next', [ScheduleController::class, 'scheduleNext'])->name('next');
    });

    Route::get('/youtube', [ScheduleController::class, 'fetchYouTube'])->name('youtube');

    Route::prefix('editor')->name('editor.')->group(function () {
        Route::get('/{id}', [EditorController::class, 'show'])->name('show');
    });
});
